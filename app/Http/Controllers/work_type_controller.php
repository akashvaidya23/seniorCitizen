<?php

namespace App\Http\Controllers;
use App\Models\work_type;

use Illuminate\Http\Request;

class work_type_controller extends Controller
{
    public function index()
    {
        if(in_array('4_1',session('access')))
        {
            $work = work_type::all();
            return view('CreateWork',compact('work'));
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
                $work = work_type::insert([
                    'type_of_work'=>$request->work,
                    'Active'=>$request->deactivate,
                ]);
            }
            elseif(in_array('4_3',session('access')) && in_array('4_5',session('access')))
            {
                $work = work_type::find($request->id)->update([
                    'type_of_work'=>$request->work,
                    'Active'=>$request->deactivate,
                ]);
            }
            $works = work_type::all();
            return view('Listworks',compact('works'));
        }
        else
        {
            return view('unauth');
        }
    }
}
