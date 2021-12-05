<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\disease;

class DiseaseController extends Controller
{
    public function index()
    {
        if(in_array('4_1',session('access')))
        {
            $disease = disease::all();
            return view('CreateDiseases',compact('disease'));
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
                $disease = disease::insert([
                    'name_of_disease' =>$request -> diseases,
                    'Active' =>$request->deactivate,
                ]);
            }
            elseif(in_array('4_3',session('access')) && in_array('4_5',session('access')))
            {
                $disease = disease::find($request->id)->update([
                    'name_of_disease' =>$request -> diseases,
                    'Active' =>$request->deactivate,
                ]);
            }
            
            $diseases = disease::all();
            return view('ListDiseases',compact('diseases'));
        }
        else
        {
            return view('unauth');
        }
    }
}