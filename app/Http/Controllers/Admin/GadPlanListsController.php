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
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use PDF;
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
        $data = AdminListing::create(GadPlanList::class) 
          ->modifyQuery(
            function($query) use ($request){
            if (Auth::user()->roles()->pluck('id')[0] == 2) {
                $gad = GadPlan::where([
                    ['model_id', '=', Auth::user()->id],
                    ['status', '=', 0],
                ])->first();
                $query->where('gad_plans_id', '=', !is_null($gad) ? $gad->id : null);    
            }
        })
        ->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'gad_plans_id', 'gad_issue_mandate', 'cause_of_issue' , 'gad_statement_objective','relevant_agencies', 'gad_activity', 'indicator_target','budget_requirement', 'budget_source', 'responsible_unit'],

            // set columns to searchIn
            ['id', 'gad_issue_mandate', 'cause_of_issue', 'gad_statement_objective', 'gad_activity', 'indicator_target'],
            function($query) use ($request) {
                $query->with(['relevant_agency', 'sourceofbudget' ,'gad_plan']);
            }
        );

        //Check if user is an admin
        if(Auth::user()->roles()->pluck('id')[0] == 1 && !is_null($id)){
            $data->where('id', $id);
            $gad = GadPlan::find($id);
            $status = $gad->status; 
        }else {
;
            $status = !is_null($data->first()) ? $data->first()->gad_plan->status : null;
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
        $schools = School::get();

        return view('admin.gad-plan-list.create', [
            'relevant_agencies' => $relevant_agencies, 
            'budget_source' => $source_of_budget,
            'responsible_unit' => $schools,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreGadPlanList $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreGadPlanList $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        
        $gp = GadPlan::where([
            ['model_id', '=', Auth::user()->id], 
            ['implement_year', '=', null],
        ])->latest('id')->first(); 
        
        $sanitized['budget_source'] = 'GAA';

        if(is_null($gp)){
            $gad = new GadPlan(); 
            $gad->model_id = Auth::user()->id;
            $gad->save();
            $sanitized['gad_plans_id'] = $gad->id;
        }else{             
            $gp->update([
                'model_id' =>  Auth::user()->id,
            ]);

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
    public function show($id, GadPlanList $gadPlanList)
    {

        $data = $gadPlanList->where('gad_plans_id', $id)->with(['gad_plan', 'relevant_agency', 'sourceofbudget']);
        return view('admin.gad-plan-list.show', ['data' => $data->get(), 'sum' => $data->sum('budget_requirement')]);

        // TODO your code goes here
    }


    public function export($id, GadPlanList $gadPlanList){ 
        $data = $gadPlanList->where('gad_plans_id', $id)->with(['gad_plan', 'relevant_agency', 'sourceofbudget'])->get();

        $pdf = PDF::loadView('admin.gad-plan-list.pdf', ['data' => $data, 'sum' => $data->sum('budget_requirement')])
        ->setPaper('legal', 'landscape');

        return $pdf->stream();
        
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
