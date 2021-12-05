<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\govt_scheme_type;

class govt_schemeController extends Controller
{
    public function index()
    {
        if(in_array('4_1',session('access')))
        {
            $scheme = govt_scheme_type::all();
            return view ('CreateScheme',compact('scheme'));
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
                $govt_scheme = govt_scheme_type::insert([
                    'type_of_govt_scheme' => $request ->scheme,
                    'Active' =>$request->deactivate,
                ]); 
            }
            else
            {
                $govt_scheme = govt_scheme_type::find($request->id)->update([
                    'type_of_govt_scheme' => $request ->scheme,
                    'Active' =>$request->deactivate,
                ]); 
            }
            $schemes = govt_scheme_type::all();
            return view('ListSchemes',compact('schemes'));
        }
        else
        {
            return view('unauth');
        }
    }
}
