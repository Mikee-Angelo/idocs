<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Models
use App\Models\Agency;

//Request
use App\Http\Requests\StoreAgencyRequest;

//Others
use Yajra\DataTables\DataTables;

class AgencyController extends Controller
{
    //
    public function index(Request $request) { 
        if ($request->ajax()) {
            $data = Agency::get(); 

            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function($row) {
                    $date = \Carbon\Carbon::parse($row->created_at);

                    return $date->format('M d, Y');
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="#" class="edit btn btn-success btn-sm mr-2">Edit</a><button type="button" data-remote="'.$row->id.'" class="del-btn delete btn btn-danger btn-sm">Delete</button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('agency.index'); 
    }

    public function create() { 
        return view('agency.create');
    }

    public function store(StoreAgencyRequest $request) { 
        $validated = $request->validated();

        $agency = new Agency; 

        $agency->name = $validated['name'];

        $agency->save(); 
        
        return redirect('agencies/create')->with('status', [
            'title' => 'Success',
            'description' => 'Campus registered successully',
        ]);
    }

    public function destroy(String $id) { 
        $campus = Agency::find($id);

        $campus->delete();
    }
}
