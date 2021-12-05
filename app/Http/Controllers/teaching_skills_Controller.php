<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\teaching_skills;

class teaching_skills_Controller extends Controller
{
    public function index()
    {
        if(in_array('4_1',session('access')))
        {
            $teaching_skills = teaching_skills::all();
            return view('CreateTeachingSkill',compact('teaching_skills'));
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
                $teaching_skills = teaching_skills::insert([
                    'name_of_skill'=>$request->teaching,
                    'Active'=>$request->deactivate,
                ]);
            }
            elseif(in_array('4_3',session('access')) && in_array('4_5',session('access')))
            {
                $teaching_skills = teaching_skills::find($request->id)->update([
                    'name_of_skill'=>$request->teaching,
                    'Active'=>$request->deactivate,
                ]);
            }
            $teaching = teaching_skills::all();
            return view('ListTeaching',compact('teaching'));
        }
        else
        {
            return view('unauth');
        }
    }
}