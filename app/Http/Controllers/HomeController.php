<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\district;
use App\Models\taluka;
use App\Models\village;
use App\Models\details_of_citizen;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $role=Auth::user()->role_id;
        if($role == 4)
        {
            return view('dashboard');
        }
        else
        {
           if(Auth::user()->district_id != '')
            {
                $district= DB::table("districts")
                ->where("id",Auth::user()->district_id)
                ->get();    
            }
            else
            {
                $district= district::all();
            }
            
            if(Auth::user()->district_id != '')
            {   
                $taluka = DB::table("talukas")
                    ->where("district_id",Auth::user()->district_id)
                    ->get();    
            }
            else
            {
                $taluka = '';
            }
            if( Auth::user()->district_id == '')
            {
                $district_count = $this->AllDistrict();
            }
            elseif(Auth::user()->taluka_id == '')
            {
                $district_count =  $this->AllTaluka(Auth::user()->district_id);
            }
            else
            {
                $district_count = $this->CountVillage(Auth::user()->taluka_id);
            }

            return view('DivisionalDashboard',compact('district_count','district','taluka'));
        }
    }

    public function AllTaluka($districtID)
    {
        return $taluka_count = DB::table('details_of_citizens')
                                    ->where('District',$districtID)
                                    ->join('talukas','talukas.id','=','details_of_citizens.Taluka')
                                    ->select('taluka_name as name', DB::raw('count(*) as total'))
                                    ->groupBy('taluka_name')
                                    ->get();
    }

    public function AllDistrict()
    {
        return $taluka_count = DB::table('details_of_citizens')
                    ->join('districts','districts.id','=','details_of_citizens.District')
                    ->select('name_of_district as name', DB::raw('count(*) as total'))
                    ->groupBy('name_of_district')
                    ->get();
    }

    public function CountVillage($id)
    {
        return $taluka_count = DB::table('details_of_citizens')
                    ->where('Taluka',$id)
                    ->join('villages','villages.id','=','details_of_citizens.Village')
                    ->select('name_of_village as name', DB::raw('count(*) as total'))
                    ->groupBy('name_of_village')
                    ->get();   
    }
}