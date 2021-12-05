<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\help_type;

class help_typeController extends Controller
{
    public function index()
    {
        if(in_array('4_1',session('access')))
        {
            $help = help_type::all();
            return view('Create_Help_type',compact('help'));
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
                $help_types = help_type::insert([
                    'type_of_help' =>$request -> help,
                    'Active' =>$request->deactivate,
                ]);    
            }
            elseif(in_array('4_3',session('access')) && in_array('4_5',session('access')))
            {
                $help_types = help_type::find($request->id)->update([
                    'type_of_help' =>$request -> help,
                    'Active' =>$request->deactivate,
                ]);    
            }
            $HTypes = help_type::all();
            return view('Help_type_list',compact('HTypes'));
        }
        else
        {
            return view('unauth');
        }
    }
}
