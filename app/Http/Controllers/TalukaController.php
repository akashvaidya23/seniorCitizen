<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\taluka;
use App\Models\district;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class TalukaController extends Controller
{
    public function index()
    {
        $district = district::all();
        $taluka =  DB::table('talukas')
                    ->join('districts','districts.id','=','talukas.district_id')
                    ->select('districts.id','districts.name_of_district','districts.state_id',
                            'talukas.id','talukas.district_id','talukas.taluka_name','talukas.state_id','talukas.Active')
                    ->get();
        return view('CreateTaluka',compact('taluka','district'));
    }

    public function insert(Request $request)
    {
        if(in_array('4_2',session('access')) && in_array('4_5',session('access')))
        {
            if($request->id == '')
            {
                $taluka = taluka::insert([
                    'district_id'=>$request->district,
                    'taluka_name' =>$request->Taluka,
                    'Active'=>$request->deactivate,
                ]);       
            }
            elseif(in_array('4_3',session('access')) && in_array('4_5',session('access')))
            {
                $taluka = taluka::find($request->id)->update([
                    'district_id'=>$request ->district,
                    'taluka_name' =>$request -> Taluka,
                    'Active' =>$request->deactivate,
                ]);
            }
            $talukas =  DB::table('talukas')
                    ->join('districts','districts.id','=','talukas.district_id')
                    ->select('districts.id','districts.name_of_district','districts.state_id',
                            'talukas.id','talukas.district_id','talukas.taluka_name','talukas.state_id','talukas.Active')
                    ->get();
            return view ('ListTaluka',compact('talukas'));
        }
        else
        {
            return view('unauth');
        }
    }
}