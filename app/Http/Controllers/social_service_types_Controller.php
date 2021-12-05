<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\social_service_types;

class social_service_types_Controller extends Controller
{
    public function index()
    {
        if(in_array('4_1',session('access')))
        {
            $social = social_service_types::all();
            return view ('CreateSocialtype',compact('social'));
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
                $social = social_service_types::insert([
                    'type_of_social_service' => $request ->social,
                    'Active'=>$request ->deactivate,
                ]);
            }
            elseif(in_array('4_3',session('access')) && in_array('4_5',session('access')))
            {
                $social = social_service_types::find($request->id)->update([
                    'type_of_social_service' => $request ->social,
                    'Active'=>$request ->deactivate,
                ]);
            }
            $social_service = social_service_types::all();
            return view('ListSocial',compact('social_service'));
        }
        else
        {
            return view('unauth');
        }
    }
}