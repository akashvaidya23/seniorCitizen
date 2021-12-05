<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\hobbies;

class HobbyController extends Controller
{
    public function index()
    {
        if(in_array('4_1',session('access')))
        {
            $hobby = hobbies::all();
            return view('CreateHobby',compact('hobby'));
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
                $hobby = hobbies::insert([
                    'name_of_hobby'=>$request -> hobby,
                    'Active' =>$request->deactivate,
                ]);    
            }
            elseif(in_array('4_3',session('access')) && in_array('4_5',session('access')))
            {
                $hobby = hobbies::find($request->id)->update([
                    'name_of_hobby'=>$request -> hobby,
                    'Active' =>$request->deactivate,
                ]);
            }
            $hobbies = hobbies::all();
            return view('Listhobbies',compact('hobbies'));
        }
        else
        {
            return view('unauth');
        }
    }
}