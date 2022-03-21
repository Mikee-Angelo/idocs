<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

//Models
use App\Models\Gadplan; 
use App\Models\GadplanList; 
use App\Models\Agency; 
use App\Models\Campus; 
use App\Models\Budget;

//Requests
use App\Http\Requests\GadplanList\StoreGadplanListRequest;

//Others
use Yajra\DataTables\DataTables;

class GadplanController extends Controller
{
    //
    public function index(Request $request) { 
        if ($request->ajax()) {
            $user = Auth::user();

            if($user->hasRole('Super Admin')){ 
                $gad = Gadplan::with('user')->get(); 
            }else{ 
                $gad = Gadplan::with('user')->where('user_id', $user->id)->get();
            }

            return Datatables::of($gad)
                ->editColumn('user', function($row) {
                    return $row->user->name;
                })
                ->editColumn('status', function($row){
                    return ucfirst($row->status);
                })
                ->editColumn('created_at', function($row) {
                    $date = \Carbon\Carbon::parse($row->created_at);

                    return $date->format('M d, Y');
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">View</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('gadplan.index');
    }

    public function create() { 
        $list = Gadplan::where('user_id', Auth::id())->get();
        
        if($list->count() > 0) { 
            return redirect('gadplans/1/items');
        }

        $agencies = Agency::get();
        $campuses = Campus::get();

        return view('gadplan.create', compact('agencies', 'campuses'));
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
