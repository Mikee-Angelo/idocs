<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RelevantAgency\BulkDestroyRelevantAgency;
use App\Http\Requests\Admin\RelevantAgency\DestroyRelevantAgency;
use App\Http\Requests\Admin\RelevantAgency\IndexRelevantAgency;
use App\Http\Requests\Admin\RelevantAgency\StoreRelevantAgency;
use App\Http\Requests\Admin\RelevantAgency\UpdateRelevantAgency;
use App\Models\RelevantAgency;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RelevantAgenciesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexRelevantAgency $request
     * @return array|Factory|View
     */
    public function index(IndexRelevantAgency $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(RelevantAgency::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'name'],

            // set columns to searchIn
            ['id', 'name']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.relevant-agency.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.relevant-agency.create');

        return view('admin.relevant-agency.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRelevantAgency $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreRelevantAgency $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the RelevantAgency
        $relevantAgency = RelevantAgency::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/relevant-agencies'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/relevant-agencies');
    }

    /**
     * Display the specified resource.
     *
     * @param RelevantAgency $relevantAgency
     * @throws AuthorizationException
     * @return void
     */
    public function show(RelevantAgency $relevantAgency)
    {
        $this->authorize('admin.relevant-agency.show', $relevantAgency);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param RelevantAgency $relevantAgency
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(RelevantAgency $relevantAgency)
    {
        $this->authorize('admin.relevant-agency.edit', $relevantAgency);


        return view('admin.relevant-agency.edit', [
            'relevantAgency' => $relevantAgency,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRelevantAgency $request
     * @param RelevantAgency $relevantAgency
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateRelevantAgency $request, RelevantAgency $relevantAgency)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values RelevantAgency
        $relevantAgency->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/relevant-agencies'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/relevant-agencies');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyRelevantAgency $request
     * @param RelevantAgency $relevantAgency
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyRelevantAgency $request, RelevantAgency $relevantAgency)
    {
        $relevantAgency->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyRelevantAgency $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyRelevantAgency $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    RelevantAgency::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
