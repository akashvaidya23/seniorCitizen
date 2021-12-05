<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\handicap_type;

class HandicapController extends Controller
{
    public function index()
    {
        if(in_array('4_1',session('access')))
        {
            $handicap = handicap_type::all();
            return view ('CreateHandicapType',compact('handicap'));
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
                $handicap = handicap_type::insert([
                    'type_of_disability' =>$request -> Handicap,
                    'Active' =>$request->deactivate,
                ]);
            }
            elseif(in_array('4_3',session('access')) && in_array('4_5',session('access')))
            {
                $handicap = handicap_type::find($request->id)->update([
                    'type_of_disability' =>$request -> Handicap,
                    'Active' =>$request->deactivate,
                ]);
            }
            $handicaps = handicap_type::all();
            return view ('ListHandicap',compact('handicaps'));
        }
        else
        {
            return view('unauth');
        }
    }
}
