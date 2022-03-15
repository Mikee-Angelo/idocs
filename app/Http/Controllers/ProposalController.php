<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Models
use App\Models\Proposal;
use App\Models\Gadplan; 

//Others
use Yajra\DataTables\DataTables;


class ProposalController extends Controller
{
    //
    public function index(Request $request) { 
           if ($request->ajax()) {
            $data = Proposal::get(); 

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="#" class="edit btn btn-success btn-sm mr-2">Edit</a><button type="button" data-remote="'.$row->id.'" class="del-btn delete btn btn-danger btn-sm">Delete</button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('proposal.index');
    }

    public function create() { 
        $gadplans = Gadplan::get();

        return view('proposal.create', compact('gadplans'));
    }

    public function store() {
    }
}
