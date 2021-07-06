<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LiquidationItem\BulkDestroyLiquidationItem;
use App\Http\Requests\Admin\LiquidationItem\DestroyLiquidationItem;
use App\Http\Requests\Admin\LiquidationItem\IndexLiquidationItem;
use App\Http\Requests\Admin\LiquidationItem\StoreLiquidationItem;
use App\Http\Requests\Admin\LiquidationItem\UpdateLiquidationItem;
use App\Models\LiquidationItem;
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

class LiquidationItemsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexLiquidationItem $request
     * @return array|Factory|View
     */
    public function index(IndexLiquidationItem $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(LiquidationItem::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            [''],

            // set columns to searchIn
            ['']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.liquidation-item.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.liquidation-item.create');

        return view('admin.liquidation-item.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreLiquidationItem $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreLiquidationItem $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the LiquidationItem
        $liquidationItem = LiquidationItem::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/liquidation-items'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/liquidation-items');
    }

    /**
     * Display the specified resource.
     *
     * @param LiquidationItem $liquidationItem
     * @throws AuthorizationException
     * @return void
     */
    public function show(LiquidationItem $liquidationItem)
    {
        $this->authorize('admin.liquidation-item.show', $liquidationItem);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param LiquidationItem $liquidationItem
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(LiquidationItem $liquidationItem)
    {
        $this->authorize('admin.liquidation-item.edit', $liquidationItem);


        return view('admin.liquidation-item.edit', [
            'liquidationItem' => $liquidationItem,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLiquidationItem $request
     * @param LiquidationItem $liquidationItem
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateLiquidationItem $request, LiquidationItem $liquidationItem)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values LiquidationItem
        $liquidationItem->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/liquidation-items'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/liquidation-items');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyLiquidationItem $request
     * @param LiquidationItem $liquidationItem
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyLiquidationItem $request, LiquidationItem $liquidationItem)
    {
        $liquidationItem->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyLiquidationItem $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyLiquidationItem $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    LiquidationItem::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
