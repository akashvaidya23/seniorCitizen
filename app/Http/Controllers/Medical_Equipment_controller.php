<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\medical_equipment_type;

class Medical_Equipment_controller extends Controller
{
    public function index()
    {
        if(in_array('4_1',session('access')))
        {
            $medical_equipments = medical_equipment_type::all();
            return view ('createMedicalEquipment',compact('medical_equipments'));
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
                $equipment = medical_equipment_type::insert([
                    'name_of_equipment' =>$request -> Equipment,
                    'Active' => $request->deactivate,
                ]);
            }
            elseif(in_array('4_3',session('access')) && in_array('4_5',session('access')))
            {
                $equipment = medical_equipment_type::find($request->id)->update([
                    'name_of_equipment' =>$request -> Equipment,
                    'Active' => $request -> deactivate,
                ]);
            }
            $equipments = medical_equipment_type::all();
            return view ('ListEquipments',compact('equipments'));
        }
        else
        {
            return view('unauth');
        }
    }
}