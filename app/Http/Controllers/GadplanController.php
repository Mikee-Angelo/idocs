<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Models
use App\Models\Gadplan; 

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
        return view('gadplan.create');
    }

    public function store() { 
        dd('test');
    }
}
