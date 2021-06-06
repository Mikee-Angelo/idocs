<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\School\BulkDestroySchool;
use App\Http\Requests\Admin\School\DestroySchool;
use App\Http\Requests\Admin\School\IndexSchool;
use App\Http\Requests\Admin\School\StoreSchool;
use App\Http\Requests\Admin\School\UpdateSchool;
use App\Models\School;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SchoolsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexSchool $request
     * @return array|Factory|View
     */
    public function index(IndexSchool $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(School::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'name', 'admin_users_id', 'status'],

            // set columns to searchIn
            ['id', 'name', 'address'],
            function($query) use ($request) {
                $query->with('admin_user');
            }
        );
        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.school.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.school.create');

        return view('admin.school.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSchool $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreSchool $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        
        $sanitized['admin_users_id'] = Auth::user()->id; 
        // Store the School
        $school = School::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/schools'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/schools');
    }

    /**
     * Display the specified resource.
     *
     * @param School $school
     * @throws AuthorizationException
     * @return void
     */
    public function show(School $school)
    {
        $this->authorize('admin.school.show', $school);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param School $school
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(School $school)
    {
        $this->authorize('admin.school.edit', $school);


        return view('admin.school.edit', [
            'school' => $school,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSchool $request
     * @param School $school
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateSchool $request, School $school)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values School
        $school->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/schools'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/schools');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroySchool $request
     * @param School $school
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroySchool $request, School $school)
    {
        $school->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroySchool $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroySchool $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    School::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
