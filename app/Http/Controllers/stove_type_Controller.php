<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\stove_type;

class stove_type_Controller extends Controller
{
    public function index()
    {
        if(in_array('4_1',session('access')))
        {
            $stove = stove_type::all();
            return view('CreateStove',compact('stove'));
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
                $stove = stove_type::insert([
                    'type_of_stove' =>$request->stove,
                    'Active' =>$request->deactivate,
                ]);
            }
            elseif(in_array('4_3',session('access')) && in_array('4_5',session('access')))
            {
                $stove = stove_type::find($request->id)->update([
                    'type_of_stove' =>$request->stove,
                    'Active' =>$request->deactivate,
                ]);
            }
            $stoves = stove_type::all();
            return view('ListStove',compact('stoves'));
        }
        else
        {
            return view('unauth');
        }
    }
}
