<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Page;
use App\Models\Action;
use App\Models\Access_control_level;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccessController extends Controller
{
    public function index()
    {
        if(in_array('3_1',session('access')))
        {
            $role = Role::all();
            $page = page::all();
            $act = Action::all();
            return view ('CreateAccess',['act'=>$act,'role'=>$role,'page'=>$page]);
        }
        else
        {
            return view('unauth');
        }
    }

    public function create(Request $request)
    {
        if(in_array('3_1',session('access')))
        {
            $value = ($request->Action_id);
            DB::delete('delete from access_control_levels where Role_id = ?',[$request->role_id]);
            foreach ($value as $b)
            {
                $x = explode('_',$b);
                $Access_control_level = Access_control_level::insert([
                    'Role_id' => $request->role_id,
                    'Page_id' => $x[0],
                    'Action_id' => $x[1],
                ]);
            }
            return redirect()->back()->with(compact('Access_control_level'));
        }
        else
        {
            return view('unauth');
        }
    }

    public function getRoleACL($role_id)
    {
        if(in_array('3_1',session('access')))
        {
            $c = DB::table('access_control_levels')
                    ->where('role_id',$role_id)
                    ->select('access_control_levels.Page_id','access_control_levels.Action_id')
                    ->get()
                    ->toArray();
            if(count($c) > 0)
            {
                $i = 0;
                foreach ($c as $access)
                {
                    $sess_access[$i] = $access->Page_id."_".$access->Action_id;
                    $i++;
                }
                print_r(json_encode($sess_access));
            }
        }    
        else
        {
            return view('unauth');
        }
    }
}