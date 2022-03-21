<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Facades
use Illuminate\Support\Facades\DB;

//Others
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;

//Models
use App\Models\User; 
use App\Models\Campus; 

//Request 
use App\Http\Requests\ManageUser\StoreManageUserRequest; 

class UserController extends Controller
{
    //
    public function index(Request $request) { 
        if ($request->ajax()) {
            $data = User::with('roles')->get(); 

            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function($row) {
                    $date = \Carbon\Carbon::parse($row->created_at);

                    return $date->format('M d, Y');
                })
                ->addColumn('role', function($row){
                    $role = $row->roles->pluck('name');
                    return $role[0] ?? '';
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="#" class="edit btn btn-success btn-sm mr-2">Edit</a><button type="button" data-remote="'.$row->id.'" class="del-btn delete btn btn-danger btn-sm">Delete</button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('manage-user.index'); 
    }

    public function create() { 
        $roles = Role::get();
        $campuses = Campus::get();
        
        return view('manage-user.create', compact('roles', 'campuses'));
    }

    public function store(StoreManageUserRequest $request) { 
        $validated = $request->validated(); 

        DB::transaction(function () use ($validated) {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt('1234567890'),
            ]);

            $user->assignRole($validated['role']);
        });

        return redirect('manage-users/create')->with('status', [
            'title' => 'Success',
            'description' => 'User registered successully',
        ]);

    }
}
