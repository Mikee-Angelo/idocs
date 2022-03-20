<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Models
use App\Models\GadplanList; 
use App\Models\Agency;
use App\Models\Campus;

//Others
use Yajra\DataTables\DataTables;

//Requests
use App\Http\Requests\GadplanList\StoreGadplanListRequest;

class GadplanListController extends Controller
{
    //
    public function index(String $id, Request $request) { 

        if ($request->ajax()) {
            $data = GadPlanList::get(); 

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="#" class="edit btn btn-success btn-sm mr-2">Edit</a><button type="button" data-remote="'.$row->id.'" class="del-btn delete btn btn-danger btn-sm">Delete</button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }


        return view('gadplan-list.index', compact('id'));
    }

    public function create() { 
        $agencies = Agency::get();
        $campuses = Campus::get(); 

        return view('gadplan-list.create', compact('agencies', 'campuses'));
    }

    public function store(StoreGadplanListRequest $request) { 

       $validated = $request->validated();
       $id = Auth::id();

       $gad = GadPlan::where('user_id', $id)->latest()->first(); 

       $payload = [
           'user_id' => $id, 
           'status' => 1,
       ];

       if(is_null($gad)) { 
            $payload['implement_year'] = \Carbon\Carbon::now()->year;
       }else{
            $payload['implement_year'] = $gad->implement_year + 1;
       }
       
       $gad = GadPlan::create($payload);

       $list = new GadplanList;

       $list->gad_plan_id = $gad->id; 
       $list->gad_issue_mandate = $validated['gad_issue_mandate']; 
       $list->cause_of_issue = $validated['cause_of_issue']; 
       $list->gad_statement_objective = $validated['gad_statement_objective'];
       $list->relevant_agencies = $validated['relevant_agencies']; 
       $list->gad_activity = $validated['gad_activity'];
       $list->indicator_target = $validated['indicator_target']; 
       $list->budget_requirement = $validated['budget_requirement']; 
       $list->budget_source = 1;
       $list->responsible_unit = $validated['responsible_unit'];

       $list->save(); 

        return redirect('gadplans/'.$gad->id.'/items');
    }
}
