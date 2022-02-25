<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//Models
use App\Models\Campus; 

//Others
use Yajra\DataTables\DataTables;

//Request
use App\Http\Requests\AddCampusRequest; 

class CampusController extends Controller
{
    //
    public function index(Request $request) {   
        if ($request->ajax()) {
            $data = Campus::get(); 

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="#" class="edit btn btn-success btn-sm mr-2">Edit</a><button type="button" data-remote="'.$row->id.'" class="del-btn delete btn btn-danger btn-sm">Delete</button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('campus.index'); 
    }

    public function create() { 
        return view('campus.create');
    }

    public function store(AddCampusRequest $request){ 
        $validated = $request->validated();

        $campus = new Campus; 

        $campus->campus_name = $validated['campus_name'];
        $campus->address = $validated['address']; 
        $campus->letter_header = $validated['letter_header']; 
        $campus->user_id = Auth::id();
        $campus->status = $validated['status'] == 'on' ? true : false; 

        $campus->save();

       return redirect('campus/create')->with('status', [
            'title' => 'Success',
            'description' => 'Campus registered successully',
        ]);
    }

    public function destroy(String $id) { 
        $campus = Campus::find($id);

        $campus->delete();

    }
}
