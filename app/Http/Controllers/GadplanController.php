<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

//Models
use App\Models\Gadplan; 
use App\Models\GadplanList; 

//Others
use Yajra\DataTables\DataTables;

class GadplanController extends Controller
{
    //
    public function index(Request $request) { 
        if ($request->ajax()) {

            $gad = Gadplan::get(); 

            return Datatables::of($gad)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('gadplan.index');
    }

    public function create() { 
        $list = Gadplan::where('user_id', Auth::id())->get();
        
        if($list->count() == 0) { 
            return redirect('gadplans/1/items');
        }

        return view('gadplan.create');
    }

    public function store(StoreGadplanListRequest $request) { 
       $validated = $request->validated();

       $gad = new GadPlan; 

       $gad->user_id = Auth::id(); 
       $gad->status = $validated['status'];
       $gad->implement_year = $validated['implement_year'];

       $gad->save();

       $list = new GadplanList;

       $list->gad_plan_id = $gad->id; 
       $list->gad_issue_mandate = $validated['gad_issue_mandate']; 
       $list->cause_of_issue = $validated['cause_of_issue']; 
       $list->gad_statement_objective = $validated['gad_statement_objective'];
       $list->relevant_agencies = $validated['relevant_agencies']; 
       $list->gad_activity = $validated['gad_activity'];
       $list->indicator_target = $validated['indicator_target']; 
       $list->budget_requirement = $validated['budget_requirement']; 
       $list->budget_source = $validated['budget_source']; 
       $list->responsible_unit = $validated['responsible_unit'];

       $list->save(); 

        return redirect('gadplans/'.$gad->id.'/items');
    }
}
