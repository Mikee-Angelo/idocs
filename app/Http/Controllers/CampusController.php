<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Models
use App\Models\Campus; 

//Others
use Yajra\DataTables\DataTables;

class CampusController extends Controller
{
    //
    public function index(Request $request) {   
        if ($request->ajax()) {
            $data = Campus::get(); 

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('campus.index'); 
    }
}
