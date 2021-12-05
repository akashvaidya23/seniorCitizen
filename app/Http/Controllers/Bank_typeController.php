<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank_type;

class Bank_typeController extends Controller
{
    public function index()
    {
        if(in_array('4_1',session('access')))
        {
            $Bank_type = Bank_type::all();
            return view('CreateBankType',compact('Bank_type'));
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
                $Bank_type = Bank_type::insert([
                    'type_of_bank' =>$request -> bank_type,
                    'Active' =>$request->deactivate,
                ]);    
            }
            elseif(in_array('4_3',session('access')) && in_array('4_5',session('access')))
            {
                $Bank_type = Bank_type::find($request->id)->update([
                    'type_of_bank' =>$request -> bank_type,
                    'Active' =>$request->deactivate,
                ]);    
            }
            
            $Bank_types = Bank_type::all();

            return view('ListBank_type',compact('Bank_types'));
        }
        else
        {
            return view('unauth');
        }
    }
}