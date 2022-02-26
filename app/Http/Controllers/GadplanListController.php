<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Models
use App\Models\GadplanList; 
use App\Models\Agency;
use App\Models\Campus;

//Others
use Yajra\DataTables\DataTables;

class GadplanListController extends Controller
{
    //
    public function index(Request $request) { 

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


        return view('gadplan-list.index');
    }

    public function create() { 
        $agencies = Agency::get();
        $campuses = Campus::get(); 

        return view('gadplan-list.create', compact('agencies', 'campuses'));
    }

    public function store() { 
        $list = new GadplanList; 
        
    }
}
