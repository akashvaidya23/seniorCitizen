<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income_source;

class Income_sourceController extends Controller
{
    public function index()
    {
        if(in_array('4_1',session('access')))
        {
            $income = Income_source::all();
            return view('CreateIncomeSource',compact('income'));
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
            if($request->id =='')
            {
                $income = Income_source::insert([
                    'type_of_income_source' =>$request -> income,
                    'Active' =>$request->deactivate,
                ]);    
            }
            elseif(in_array('4_3',session('access')) && in_array('4_5',session('access')))
            {
                $income = Income_source::find($request->id)->update([
                    'type_of_income_source' =>$request -> income,
                    'Active' =>$request->deactivate,
                ]);
            }
            $ISource = Income_source::all();
            return view('ListIncomeSource',compact('ISource'));
        }
        else
        {
            return view('unauth');
        }    
    }
}
