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
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use PDF;
use Illuminate\Http\Request;


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
        $data = AdminListing::create(Liquidation::class)
        ->modifyQuery(function($query) use ($request){
            if (Auth::user()->roles()->pluck('id')[0] == 1) {
                $query->where('status', '!=', 0);
            }else{ 
                $query->where([
                    ['admin_users_id', '=',Auth::user()->id],
                ]);
            }
        })
        ->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'purpose', 'status', 'isSent', 'created_at'],

            // set columns to searchIn
            ['id', 'purpose'],

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
        $sanitized['admin_users_id'] = Auth::user()->id;
        // Store the Liquidation
        $liquidation = Liquidation::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/liquidations'.$liquidation->id.'/items'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/liquidations'.$liquidation->id.'/items');
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

    public function submit($id){ 
        try { 
            $lq = Liquidation::where([
                ['id', '=', $id],
                ['admin_users_id', '=', Auth::user()->id],
                ['status', '=', 0]
            ])->update([
                'status' => 1
            ]);

            return response([
                'redirect' => url('admin/liquidations/'.$id.'/items'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded')
            ]);
        } catch (Exception $e){ 
            abort(400);
        }

    }

    public function export($id)
    {
        $data = Liquidation::where([
            ['id', '=', $id], 
        ])->with(['liquidation_items'])->firstOrFail();

        $pdf = PDF::loadView('admin.liquidation-item.pdf', ['data' => $data])
        ->setPaper('a4', 'portrait');

        return $pdf->stream();
        // TODO your code goes here
    }

    public function changeStatus(Liquidation $liquidation, Request $request) { 
    
        $liquidation->status = $request->status ? 2 : 3;
        $liquidation->save(); 
        
        // if($request->status == 2){ 
        //     Mail::to(Auth::user()->email)->send(new AcceptedGadPlan($liquidation->implement_year));
        // }else{ 
        //     Mail::to(Auth::user()->email)->send(new DeclinedGadPlan($gadPlan->implement_year));
        // }

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/liquidations/'.$liquidation->id.'/items'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/liquidations/'.$liquidation->id.'/items');
    }
}
