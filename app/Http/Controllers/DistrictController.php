<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\district;

class DistrictController extends Controller
{
    public function index()
    {
        $district = district::all();
        return view('CreateDistrict',compact('district'));
    }

    public function insert(Request $request)
    {
       if(in_array('4_2',session('access')) && in_array('4_5',session('access')))
        {
            if($request->id == '')
            {
                $district = district::insert([
                    'name_of_district'=>$request->District,
                    'Active'=>$request->deactivate,
                ]);
            }
            elseif(in_array('4_3',session('access')) && in_array('4_5',session('access')))
            {
               $district = district::find($request->id)->update([
                    'name_of_district'=>$request->District,
                    'Active'=>$request->deactivate,
                ]);
            }
            $districts = district::all();
            return view('ListDistricts',compact('districts'));        
        }
        else
        {
            return view('unauth');
        }
    }
}
