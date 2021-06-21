<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Accomplishment\BulkDestroyAccomplishment;
use App\Http\Requests\Admin\Accomplishment\DestroyAccomplishment;
use App\Http\Requests\Admin\Accomplishment\IndexAccomplishment;
use App\Http\Requests\Admin\Accomplishment\StoreAccomplishment;
use App\Http\Requests\Admin\Accomplishment\UpdateAccomplishment;
use App\Models\Accomplishment;
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
use App\Models\GadPlan;

class AccomplishmentsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexAccomplishment $request
     * @return array|Factory|View
     */
    public function index(IndexAccomplishment $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Accomplishment::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'gad_plans_id', 'header', 'created_at'],

            // set columns to searchIn
            ['id', 'description']
        );
        
        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.accomplishment.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {

        return view('admin.accomplishment.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAccomplishment $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreAccomplishment $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        
        
        $gad = GadPlan::where([
            ['model_id' ,'=', Auth::user()->id],
            ['status' ,'=', 2],
            ['implement_year', '=', date('Y')]
        ])->first();
        
        if(!is_null($gad)){ 
            $sanitized['gad_plans_id'] = $gad->id;
            $accomplishment = Accomplishment::create($sanitized);

        }
        if ($request->ajax()) {
            return ['redirect' => url('admin/accomplishments'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }
        return redirect('admin/accomplishments');
    }

    /**
     * Display the specified resource.
     *
     * @param Accomplishment $accomplishment
     * @throws AuthorizationException
     * @return void
     */
    public function show(Accomplishment $accomplishment)
    {
        $this->authorize('admin.accomplishment.show', $accomplishment);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Accomplishment $accomplishment
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Accomplishment $accomplishment)
    {

        return view('admin.accomplishment.edit', [
            'accomplishment' => $accomplishment,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAccomplishment $request
     * @param Accomplishment $accomplishment
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateAccomplishment $request, Accomplishment $accomplishment)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Accomplishment
        $accomplishment->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/accomplishments'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/accomplishments');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyAccomplishment $request
     * @param Accomplishment $accomplishment
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyAccomplishment $request, Accomplishment $accomplishment)
    {
        $accomplishment->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyAccomplishment $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyAccomplishment $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Accomplishment::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
