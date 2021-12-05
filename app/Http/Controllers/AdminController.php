<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\district;
use App\Models\taluka;
use App\Models\village;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    public function index()
    {
        if(in_array('2_1',session('access')))
        {  
            if(Auth::user()->district_id != '')
            {
                $district= DB::table("districts")
                    ->where("id",Auth::user()->district_id)
                    ->get();    
            }
            else
            {
                $district= district::all();
            }
            
            if(Auth::user()->taluka_id != '' && Auth::user()->district_id != '')
            {   
                $taluka = DB::table("talukas")
                    ->where("district_id",Auth::user()->district_id)
                    ->get();    
            }
            else
            {
                $taluka = taluka::all();
            }
           
            $village = village::all();
            $Role = DB::table("roles")
                ->where("id",">",Auth::user()->role_id)
                ->get();
            return view ('RegisterUser',compact('taluka','district','village','Role'));            
        }
        else
        {
            return view('unauth');
        }  
    }

    public function create(request $request)
    {
        if(in_array('2_1',session('access')))
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

    public function show(Request $request)
    {
        if(in_array('2_2',session('access')))
        {
            if(Auth::user()->district_id != '')
            {
                
            $users = DB::table('users')
                ->join('districts', 'district_id', '=', 'districts.id')
                ->join('talukas', 'taluka_id', '=', 'talukas.id')
                ->where("users.district_id",Auth::user()->district_id)
                ->select('users.Banned','users.id', 'users.name', 'users.email', 'districts.name_of_district', 'talukas.taluka_name')
                ->paginate(10);
            }
            else
            {
            $users = DB::table('users')
                ->leftJoin('districts', 'district_id', '=', 'districts.id')
                ->leftJoin('talukas', 'taluka_id', '=', 'talukas.id')
                ->select('users.Banned','users.id', 'users.name', 'users.email', 'districts.name_of_district', 'talukas.taluka_name')
                ->paginate(10);
            }

            return view ('Listuser',compact('users'));
        }
        else
        {
            return view('unauth');
        }
    }

    public function edit($id)
    {
        if(in_array('2_3',session('access')))
        {
            $user = User::find($id);
            $district = district::all();
            $taluka = taluka::all();
            $village = village::all();
            $Role = Role::all();
            $c = DB::table('users')
                ->where('id', $id)
                ->get();
            return view ('EditUser',compact('c','user','taluka','district','village','Role'));
        }
        else
        {
            return view('unauth');
        }

    }

    public function update(request $request, $id)
    {
        //return $request->Ban_user;
        if(in_array('2_3',session('access')))
        {
            $update = User::find($id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'district_id' => $request->district,
                'taluka_id' => $request->taluka,
                'Banned' => $request->Ban_user,
            ]);
            return redirect('/List/user');
        }
        else
        {
            return view('unauth');
        }
    }

    public function password($id)
    {
        $user = User::find($id);
        return view('ChangePassword',compact('user'));
    }

    public function InsertNewPassword(Request $request,$id)
    {
        $Password = User::find($id)->update([
            'password' => Hash::make($request['password']),
        ]);
    }
}