<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        if(in_array('4_1',session('access')))
        {
            $role = Role::all();
            return view('CreateRole',compact('role'));
        }
        else
        {
            return view('unauth');
        }
    }

    public function insert(Request $request)
    {
        if(in_array('4_2',session('access')) && in_array('4_5',session('access')))
        {
            if($request->id == '')
            {
                $role = Role::insert([
                    'name'=>$request->role,
                    'Active'=>$request->deactivate,
                ]);
            }
            elseif(in_array('4_3',session('access')) && in_array('4_5',session('access')))
            {
                $role = Role::find($request->id)->update([
                    'name'=>$request->role,
                    'Active'=>$request->deactivate,
                ]);
            }
            $roles = Role::all();
            return view('ListRoles',compact('roles'));
        }        
        else
        {
            return view('unauth');
        }
    }
}

