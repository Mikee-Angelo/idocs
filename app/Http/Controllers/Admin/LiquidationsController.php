<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Liquidation\BulkDestroyLiquidation;
use App\Http\Requests\Admin\Liquidation\DestroyLiquidation;
use App\Http\Requests\Admin\Liquidation\IndexLiquidation;
use App\Http\Requests\Admin\Liquidation\StoreLiquidation;
use App\Http\Requests\Admin\Liquidation\UpdateLiquidation;
use App\Models\Liquidation;
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

class LiquidationsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexLiquidation $request
     * @return array|Factory|View
     */
    public function index(IndexLiquidation $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Liquidation::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'admin_users_id', 'status', 'isSent'],

            // set columns to searchIn
            ['id', 'purpose']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.liquidation.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {

        return view('admin.liquidation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreLiquidation $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreLiquidation $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Liquidation
        $liquidation = Liquidation::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/liquidations'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/liquidations');
    }

    /**
     * Display the specified resource.
     *
     * @param Liquidation $liquidation
     * @throws AuthorizationException
     * @return void
     */
    public function show(Liquidation $liquidation)
    {
        $this->authorize('admin.liquidation.show', $liquidation);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Liquidation $liquidation
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Liquidation $liquidation)
    {
        $this->authorize('admin.liquidation.edit', $liquidation);


        return view('admin.liquidation.edit', [
            'liquidation' => $liquidation,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLiquidation $request
     * @param Liquidation $liquidation
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateLiquidation $request, Liquidation $liquidation)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Liquidation
        $liquidation->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/liquidations'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/liquidations');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyLiquidation $request
     * @param Liquidation $liquidation
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyLiquidation $request, Liquidation $liquidation)
    {
        $liquidation->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyLiquidation $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyLiquidation $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Liquidation::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
