<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Models
use App\Models\Budget; 

//Others
use Yajra\DataTables\DataTables;

//Requests
use App\Http\Requests\Budget\StoreBudgetRequest; 

class BudgetController extends Controller
{
    public function index(Request $request) { 
        
        if ($request->ajax()) {
            $data = Budget::get(); 

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="#" class="edit btn btn-success btn-sm mr-2">Edit</a><button type="button" data-remote="'.$row->id.'" class="del-btn delete btn btn-danger btn-sm">Delete</button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('budget.index');
    }

    public function create() { 
        return view('budget.create');
    }

    public function store(StoreBudgetRequest $request) { 
        $validated = $request->validated(); 

        $budget = new Budget; 

        $budget->name = $validated['name'];

        $budget->save();

         return redirect('budget-sources/create')->with('status', [
            'title' => 'Success',
            'description' => 'Budget source registered successully',
        ]);
    }

    public function destroy(String $id) { 
        $budget = Budget::find($id);

        $budget->delete();
    }
}
