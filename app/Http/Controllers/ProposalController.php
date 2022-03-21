<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Facades
use Illuminate\Support\Facades\Storage;

//Models
use App\Models\Proposal;
use App\Models\Gadplan; 

//Others
use Yajra\DataTables\DataTables;

//Requests
use App\Http\Requests\Proposal\CreateProposalRequest; 


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
                ->editColumn('created_at', function($row) {
                    $date = \Carbon\Carbon::parse($row->created_at);

                    return $date->format('M d, Y');
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

    public function store(CreateProposalRequest $request) {
        $validated = $request->validated(); 
        $fileModel = new Proposal;

        if($request->file()) {
            $fileModle->gadplan_id = $validated['gadplan_id'];
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');
            $fileModel->file_name = time().'_'.$request->file->getClientOriginalName();
            $fileModel->file_path = '/storage/' . $filePath;
            $fileModel->save();
        }
    }
}
