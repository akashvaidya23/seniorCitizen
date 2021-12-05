<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ration_card_type;

class RationCardController extends Controller
{
    public function index() 
    {
        if(in_array('4_1',session('access')))
        {
            $ration = ration_card_type::all();
            return view('CreateRationCard',compact('ration'));
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
                $ration = ration_card_type::insert([
                    'type_of_ration_card'=>$request->ration,
                    'Active'=>$request->deactivate,
                ]);
            }
            elseif(in_array('4_3',session('access')) && in_array('4_5',session('access')))
            {
                $ration = ration_card_type::find($request->id)->update([
                    'type_of_ration_card'=>$request->ration,
                    'Active'=>$request->deactivate,
                ]);
            }
            $rationC = ration_card_type::all();
            return view('ListRationCard',compact('rationC'));
        }
        else
        {
            return view('unauth');
        }
    }
}
