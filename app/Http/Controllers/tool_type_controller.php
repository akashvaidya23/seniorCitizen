<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tool_type;

class tool_type_controller extends Controller
{
    public function index()
    {
        if(in_array('4_1',session('access')))
        {
            $Tool = tool_type::all();
            return view ('CreateTool',compact('Tool'));
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
                $Tool = tool_type::insert([
                    'type_of_tools'=>$request->tool,
                    'Active'=>$request->deactivate,
                ]);
            }
            elseif(in_array('4_3',session('access')) && in_array('4_5',session('access')))
            {
                $Tool = tool_type::find($request->id)->update([
                    'type_of_tools'=>$request->tool,
                    'Active'=>$request->deactivate,
                ]);
            }
            $tools = tool_type::all();
            return view('ListTools',compact('tools'));
        }
        else
        {
            return view('unauth');
        }
    }
}
