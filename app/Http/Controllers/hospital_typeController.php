<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\hospital_type;

class hospital_typeController extends Controller
{
    public function index()
    {
        if(in_array('4_1',session('access')))
        {
            $hospital = hospital_type::all();
            return view('CreateHospitalType',compact('hospital'));
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
                $hospital = hospital_type::insert([
                    'type_of_hospital' =>$request -> hospital,
                    'Active' =>$request->deactivate,
                ]);    
            }
            elseif(in_array('4_3',session('access')) && in_array('4_5',session('access')))
            {
                $hospital = hospital_type::find($request->id)->update([
                    'type_of_hospital' =>$request -> hospital,
                    'Active' =>$request->deactivate,
                ]);    
            }
            $hospitals = hospital_type::all();
            return view('ListHospitalType',compact('hospitals'));
        }
        else
        {
            return view('unauth');
        }
    }
}
