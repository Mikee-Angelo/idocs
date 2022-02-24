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
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Unit;
use App\Models\Liquidation;

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
    public function create($id)
    {
        // $this->authorize('admin.liquidation-item.create');
        $unit = Unit::get();
        return view('admin.liquidation-item.create', ['unit' =>  $unit, 'id' => $id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreLiquidationItem $request
     * @return array|RedirectResponse|Redirector
     */
    public function store($id, StoreLiquidationItem $request)
    {

        // Sanitize input
        $sanitized = $request->getSanitized();
        
        foreach($sanitized['inputs'] as $datas){ 
            $sanitized['liquidation_id'] = $id;
            $sanitized['item'] = $datas['item']; 
            $sanitized['price'] = $datas['price'];
            $sanitized['qty'] = $datas['qty'];
            $sanitized['unit'] = $datas['unit'];
            $sanitized['total'] = $datas['price'] * $datas['qty'];

            $liquidationItem = LiquidationItem::create($sanitized);
        }

        if ($request->ajax()) {
            return ['redirect' => url('admin/liquidations/'.$id.'/items'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/liquidations/'.$id.'/items');
    }

    /**
     * Display the specified resource.
     *
     * @param LiquidationItem $liquidationItem
     * @throws AuthorizationException
     * @return void
     */
    public function show($id, LiquidationItem $liquidationItem)
    {
        // $this->authorize('admin.liquidation-item.show', $liquidationItem);

        $items = Liquidation::where([
            ['id', '=', $id]
        ]);

        if(Auth::user()->roles()->pluck('id')[0] == 2){ 
            $items->where('admin_users_id',  Auth::user()->id);
        }     
    
        $data = $items->with(['liquidation_items'])->first();

        if(is_null($data)) return abort(404); 
        
  
        return view('admin.liquidation-item.show', ['data' => $data, 'id' => $id]);

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
