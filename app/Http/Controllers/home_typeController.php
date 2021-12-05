<?php

namespace App\Http\Controllers;
use App\Models\home_type;

use Illuminate\Http\Request;

class home_typeController extends Controller
{
    public function index()
    {
        if(in_array('4_1',session('access')))
        {
            $home = home_type::all();
            return view('CreateHomeType',compact('home'));
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
                $home = home_type::insert([
                    'type_of_home' => $request ->Home,
                    'Active' =>$request->deactivate,
                ]);
            }
            elseif(in_array('4_3',session('access')) && in_array('4_5',session('access'))) 
            {
                $home = home_type::find($request->id)->update([
                    'type_of_home' => $request ->Home,
                    'Active' =>$request->deactivate,
                ]);
            }
            $homes = home_type::all();
            return view('ListHomes',compact('homes'));
        }
        else
        {
            return view('unauth');
        }
    }
}