<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GadPlan\BulkDestroyGadPlan;
use App\Http\Requests\Admin\GadPlan\DestroyGadPlan;
use App\Http\Requests\Admin\GadPlan\IndexGadPlan;
use App\Http\Requests\Admin\GadPlan\StoreGadPlan;
use App\Http\Requests\Admin\GadPlan\UpdateGadPlan;
use App\Models\GadPlan;
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
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class GadPlansController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexGadPlan $request
     * @return array|Factory|View
     */
    public function index( IndexGadPlan $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(GadPlan::class)
        ->modifyQuery(function($query) use ($request){
            if (Auth::user()->roles()->pluck('id')[0] == 1) {
                $query->where('status', '!=', 0);
            }else{ 
                $query->where([
                    ['model_id', '=',Auth::user()->id],
                    ['implement_year' , '!=', null]
                ]);
            }
        })
        ->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'model_id', 'status', 'created_at', 'implement_year'],

            // set columns to searchIn
            ['id', 'model_id', 'status', 'created_at', 'implement_year'],

            function($query) use ($request) {
                $query->with(['admin_user','admin_user.school' ,'gad_plan_list']);
            },
        );
        
        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

    
        return view('admin.gad-plan.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.gad-plan.create');

        return view('admin.gad-plan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreGadPlan $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreGadPlan $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the GadPlan
        $gadPlan = GadPlan::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/gad-plans'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/gad-plans');
    }

    /**
     * Display the specified resource.
     *
     * @param GadPlan $gadPlan
     * @throws AuthorizationException
     * @return void
     */
    public function show(GadPlan $gadPlan)
    {
        $this->authorize('admin.gad-plan.show', $gadPlan);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param GadPlan $gadPlan
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(GadPlan $gadPlan)
    {
        $this->authorize('admin.gad-plan.edit', $gadPlan);


        return view('admin.gad-plan.edit', [
            'gadPlan' => $gadPlan,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateGadPlan $request
     * @param GadPlan $gadPlan
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateGadPlan $request, GadPlan $gadPlan)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values GadPlan
        $gadPlan->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/gad-plans'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/gad-plans');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyGadPlan $request
     * @param GadPlan $gadPlan
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyGadPlan $request, GadPlan $gadPlan)
    {
        $gadPlan->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyGadPlan $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyGadPlan $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    GadPlan::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    public function changeStatus(GadPlan $gadPlan, Request $request) { 
    
        $gadPlan->status = $request->status ? 2 : 3;
        $gadPlan->save(); 
        if ($request->ajax()) {
            return [
                'redirect' => url('admin/gad-plans'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/gad-plans');
    }
    
    public function submitStatus(Request $request) { 
    
            $gad = GadPlan::where([
                ['implement_year', '=', null],
                ['model_id', '=', Auth::user()->id],
                ['status', '=', 0]
            ])->latest('id')->first();
            
            $yearGad = GadPlan::select('implement_year')->where([
                ['implement_year', '!=', null],
                ['model_id', '=', Auth::user()->id],
            ])->latest('id')->first();

            if(is_null($yearGad)){ 
                $gad->implement_year = date('Y') + 1;
            }else{ 
                $gad->implement_year =  $yearGad->implement_year + 1;
            }

            $gad->status = 1;
            $gad->save(); 

            if ($request->ajax()) {
                return [
                    'redirect' => url('admin/gad-plans'),
                    'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
                ];
            }
        return redirect('admin/gad-plans');
    }
}
