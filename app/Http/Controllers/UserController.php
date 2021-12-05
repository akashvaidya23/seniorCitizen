<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\model_has_role;

class UserController extends Controller
{
    // public function index()
    // {
    //     $district = district::all();
    //     $taluka = taluka::all();
    //     $village = village::all();
    //     $Role = Role::all();
    //     return view ('RegisterUser',compact('taluka','district','village','Role'));
    // }

    public function create(request $request)
    {
        if(in_array('1_1',session('access')))
        {
            $user = User::insert([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request['password']),
                'district_id' => $request->district,
                'taluka_id' => $request->taluka,
                'role_id' =>$request->role_id,
            ]);
            return redirect()->back();
        }
        else
        {
            return view('unauth');
        }  
    }
}
