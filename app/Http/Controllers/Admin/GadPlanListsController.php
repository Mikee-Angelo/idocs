<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GadPlanList\BulkDestroyGadPlanList;
use App\Http\Requests\Admin\GadPlanList\DestroyGadPlanList;
use App\Http\Requests\Admin\GadPlanList\IndexGadPlanList;
use App\Http\Requests\Admin\GadPlanList\StoreGadPlanList;
use App\Http\Requests\Admin\GadPlanList\UpdateGadPlanList;
use App\Models\GadPlanList;
use App\Models\RelevantAgency;
use App\Models\SourceOfBudget;
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
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class GadPlanListsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexGadPlanList $request
     * @return array|Factory|View
     */
    public function index(?int $id = null, IndexGadPlanList $request )
    {
        $status = null;

        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(GadPlanList::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'gad_plans_id', 'gad_issue_mandate', 'cause_of_issue' , 'gad_statement_objective','relevant_agencies', 'gad_activity', 'indicator_target','budget_requirement', 'budget_source', 'responsible_unit'],

            // set columns to searchIn
            ['id', 'gad_issue_mandate', 'cause_of_issue', 'gad_statement_objective', 'gad_activity', 'indicator_target'],
            function($query) use ($request) {
                $query->with(['relevant_agency', 'sourceofbudget']);
            }
        );

        if(!is_null($id)){ 
            $data->where('id', $id);
            $gad = GadPlan::find($id);
            $status = $gad->status;
        }else{
            $gad = GadPlan::where([
                ['status', '>', 0],
                ['model_id', '=', Auth::user()->id]
            ])->whereYear('created_at', date('Y'))->First();

            $status = !is_null($gad) ? $gad->status : null;
        }

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }


        return view('admin.gad-plan-list.index', ['data' => $data, 'id' => $id, 'status' => $status]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        // $this->authorize('admin.gad-plan-list.create');
        $relevant_agencies = RelevantAgency::get();
        $source_of_budget = SourceOfBudget::get(); 

        return view('admin.gad-plan-list.create', [
            'relevant_agencies' => $relevant_agencies, 
            'budget_source' => $source_of_budget,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreGadPlanList $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreGadPlanList $request, GadPlan $gadplan)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        
        $gp = GadPlan::whereYear('created_at', date('Y'))->first(); 

        if(is_null($gp)){ 
            $gadplan->model_id = Auth::user()->id;
            $gadplan->save();
            $sanitized['gad_plans_id'] = $gadplan->id;
        }else{ 
            $sanitized['gad_plans_id'] = $gp->id;
        }
        
        //Store data to gad plan
        $gadPlanList = GadPlanList::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/gad-plan-lists'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/gad-plan-lists');
    }

    /**
     * Display the specified resource.
     *
     * @param GadPlanList $gadPlanList
     * @throws AuthorizationException
     * @return void
     */
    public function show(GadPlanList $gadPlanList)
    {
        $this->authorize('admin.gad-plan-list.show', $gadPlanList);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param GadPlanList $gadPlanList
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(GadPlanList $gadPlanList)
    {
        $this->authorize('admin.gad-plan-list.edit', $gadPlanList);


        return view('admin.gad-plan-list.edit', [
            'gadPlanList' => $gadPlanList,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateGadPlanList $request
     * @param GadPlanList $gadPlanList
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateGadPlanList $request, GadPlanList $gadPlanList)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values GadPlanList
        $gadPlanList->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/gad-plan-lists'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/gad-plan-lists');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyGadPlanList $request
     * @param GadPlanList $gadPlanList
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyGadPlanList $request, GadPlanList $gadPlanList)
    {
        $gadPlanList->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyGadPlanList $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyGadPlanList $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    GadPlanList::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
