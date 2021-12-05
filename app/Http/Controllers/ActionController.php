<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Action;

class ActionController extends Controller
{
    public function index()
    {
        if(in_array('4_1',session('access')))
        {
            $action = Action::all();
            return view('CreateAction',compact('action'));
        }
        else
        {
            return view('unauth');
        }
    }

    public function create(Request $request)
    {
        if(in_array('4_2',session('access')) && in_array('4_5',session('access')))
        {
            if($request->id == '')
            {
                $action = Action::create([
                    'name'=>$request->action,
                    'Active' =>$request->deactivate,
                ]);
            }
            elseif(in_array('4_3',session('access')) && in_array('4_5',session('access')))
            {
                $action = Action::find($request->id)->update([
                    'name'=>$request->action,
                    'Active' =>$request->deactivate,
                ]);
            }
            $Actions = Action::all();
            return view('ListAction',compact('Actions'));
        }
        else
        {
            return view('unauth');
        }
    }
}
