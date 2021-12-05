<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\education;

class EducationController extends Controller
{
    public function index()    
    {
        if(in_array('4_1',session('access')))
        {
            $education = education::all();
            return view ('CreateEducationType',compact('education'));
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
                $education = education::insert([
                    'name_of_degree'=>$request->degree,
                    'Active'=>$request->deactivate,
                ]);
            }
            elseif(in_array('4_3',session('access')) && in_array('4_5',session('access')))
            {
                $education = education::find($request->id)->update([
                    'name_of_degree'=>$request->degree,
                    'Active'=>$request->deactivate,
                ]);
            }
            $edu = education::all();
            return view('ListEducation',compact('edu'));        
        }
        else
        {
            return view('unauth');
        }
    }
}
