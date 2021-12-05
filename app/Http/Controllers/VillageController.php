<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\district;
use App\Models\taluka;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\village;

class VillageController extends Controller
{
    public function index($id)
    {        
        if($id>0)
        {
            $v = DB::table('villages')
                ->where('id', $id)
                ->get();          
            
            $t = DB::table('talukas')
                ->where('district_id', $v[0]->District_id)
                ->get();          
        }
        else
        {
            Session::forget('id');
            $v='';
            $t='';
        }
        
        $district = district::all();
        $taluka = taluka::all();
        $village = DB::table("villages")           
                    ->join('districts','districts.id','=','villages.district_id')
                    ->join('talukas','talukas.id','=','villages.Taluka_id')
                    ->select('villages.name_of_village','talukas.taluka_name','districts.name_of_district',
                            'villages.District_id','villages.id  AS Village_id','talukas.id AS Taluka_id',
                            'talukas.district_id','districts.id AS District_id','villages.Taluka_id','villages.Active')
                    ->get()
                    ->toarray();
        return view('CreateVillage',compact('district','taluka','village','v','t','id'));
    }

    public function insert(Request $request)
    {
        if(in_array('4_2',session('access')) && in_array('4_5',session('access')))
        {
            if($request->id == '0')
            {
                //return $request->district;
                $village = village::insert([
                    'District_id'=>$request->district,
                    'Taluka_id'=>$request->taluka,
                    'name_of_village'=>$request->village,
                    'Active'=>$request->deactivate,
                ]);       
            }
            elseif(in_array('4_3',session('access')) && in_array('4_5',session('access')))
            {
                $village = village::find($request->id)->update([
                    'District_id'=>$request->district,
                    'Taluka_id'=>$request->taluka,
                    'name_of_village'=>$request->village,
                    'Active'=>$request->deactivate,
                ]);
            }
            return $village;
            // $district = district::all();
            // $taluka = taluka::all();
            // $villages = DB::table('villages')
            //         ->join('districts','districts.id','=','villages.district_id')
            //         ->join('talukas','talukas.district_id','=','districts.id')
            //         ->select('villages.name_of_village','talukas.taluka_name','districts.name_of_district',
            //                 'villages.District_id','villages.id  AS Village_id','talukas.id AS Taluka_id',
            //                 'talukas.district_id','districts.id AS District_id','villages.Taluka_id','villages.Active')
            //         ->get();

            // return view('CreateVillage',compact('district','taluka','village'));
        }
        else
        {
            return view('unauth');
        }    
    }

    public function List()//$id
    {
        //$villages = village::paginate(1000);
        $villages = DB::table("villages")           
                    ->join('districts','districts.id','=','villages.district_id')
                    ->join('talukas','talukas.id','=','villages.Taluka_id')
                     ->select('villages.name_of_village','talukas.taluka_name','districts.name_of_district',
                            'villages.District_id','villages.id  AS Village_id','talukas.id AS Taluka_id',
                            'talukas.district_id','districts.id AS District_id','villages.Taluka_id','villages.Active')
                    ->paginate(1000);
        // echo "<pre>";
        // print_r($villages);
        // die();
        return view('ListVillages',compact('villages'));
    }

    public function myformAjax($id)
    {
        $talukas = DB::table("talukas")
                    ->where("district_id",$id)
                    ->pluck("taluka_name","id");
		return json_encode($talukas);
    }
}