<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\district;
use App\Models\taluka;
use App\Models\village;
use App\Models\education;
use App\Models\details_of_citizen;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class DivisionalController extends Controller
{
    public function index()
    {
        if(Auth::user()->district_id != '')
        {
            $district = DB::table("districts")
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
            $Incomplete_Entries = DB::select(
                    DB::raw("SELECT districts.name_of_district as Name, districts.id, COUNT(details_of_citizens.District) as total
                                FROM `details_of_citizens`
                                RIGHT JOIN districts ON (details_of_citizens.District = districts.id)
                                where any_disease = '0' or Regular_check_up ='0' or are_you_handicapped ='0' or aadhar_card ='0' 
                                or aadhar_discrepancy ='0' or Voter_id ='0' or ST_pass ='0' or Govt_schemes ='0' or income_increase ='0' 
                                or tools_required ='0' or social_service ='0'
                                group by districts.name_of_district, districts.id
                                ORDER BY `total` DESC"));
        }
        elseif(Auth::user()->taluka_id == '')
        {
            $AuthDist = Auth::user()->district_id;
            $district_count =  $this->AllTaluka(Auth::user()->district_id);
            $Incomplete_Entries = DB::select(
                    DB::raw("SELECT talukas.taluka_name as Name, talukas.id ,COUNT(details_of_citizens.Taluka) as total
                                FROM `details_of_citizens`
                                RIGHT JOIN talukas ON (details_of_citizens.Taluka = talukas.id)
                                where (any_disease ='0' or Regular_check_up ='0' or are_you_handicapped ='0' or aadhar_card ='0' or aadhar_discrepancy ='0' 
                                or Voter_id ='0' or ST_pass ='0' or Govt_schemes ='0' or income_increase ='0' 
                                or tools_required ='0' or social_service ='0') and
                                talukas.district_id = $AuthDist
                                group by talukas.taluka_name, talukas.id
                                ORDER BY `total` DESC"));
        }
        else
        {
            $AuthTaluka = Auth::user()->taluka_id;
            $district_count = $this->CountVillage(Auth::user()->taluka_id);
            $Incomplete_Entries = DB::select(
                    DB::raw("SELECT villages.name_of_village as Name, villages.id, COUNT(details_of_citizens.Village) as total
                        FROM `details_of_citizens`
                        RIGHT JOIN villages ON (details_of_citizens.Village = villages.id)
                        where (any_disease ='0' or Regular_check_up ='0' or are_you_handicapped ='0' or aadhar_card ='0' or aadhar_discrepancy ='0' 
                        or Voter_id ='0' or ST_pass ='0' or Govt_schemes ='0' or income_increase ='0' 
                        or tools_required ='0' or social_service ='0') and
                        villages.Taluka_id = $AuthTaluka
                        group by villages.name_of_village, villages.id
                        ORDER BY `total` DESC"));
        }
        return view('DivisionalDashboard',compact('district_count','district','taluka','Incomplete_Entries'));
    }

    public function DistrictUserWise($District_id)
    {
        if(Auth::user()->district_id != '')
        {
            $district= DB::table("districts")
                    ->where("id",Auth::user()->district_id)
                    ->get();

            $userCount = DB::table("users")
                            ->leftjoin('details_of_citizens','details_of_citizens.created_by','=','users.id')
                            ->select('name','district_id', 'users.id', DB::raw('count(details_of_citizens.created_by) as total'))
                            ->groupBy('name','district_id','users.id')
                            ->orderBy('total','DESC')
                            ->get();
            $Incomplete_Entries = DB::select(
                    DB::raw("SELECT users.name as Name, users.id as UID, COUNT(details_of_citizens.created_by) as total 
                                FROM `details_of_citizens`
                                left join users on (details_of_citizens.created_by = users.id)
                                where (any_disease ='0' or Regular_check_up ='0' or are_you_handicapped ='0' or aadhar_card ='0' or aadhar_discrepancy ='0' or Voter_id ='0' 
                                or ST_pass ='0' or Govt_schemes ='0' or income_increase ='0' or tools_required ='0' or social_service ='0') and users.role_id = 4
                                group by users.name, users.id
                                ORDER BY `total` DESC"));  
        }
        
        elseif($District_id>0)
        {
            $district= district::all();
            $userCount = DB::table("users")
                            ->leftjoin('details_of_citizens','details_of_citizens.created_by','=','users.id')
                            ->select('name','district_id', 'users.id', DB::raw('count(details_of_citizens.created_by) as total'))
                            ->where('users.role_id','4')
                            ->where('users.district_id', $District_id)
                            ->groupBy('name','district_id', 'users.id')
                            ->orderBy('total','DESC')
                            ->get();
            $Incomplete_Entries = DB::select(
                    DB::raw("SELECT users.name as Name, users.id as UID, COUNT(details_of_citizens.created_by) as total 
                                FROM `details_of_citizens`
                                left join users on (details_of_citizens.created_by = users.id)
                                where (any_disease ='0' or Regular_check_up ='0' or are_you_handicapped ='0' or aadhar_card ='0' or aadhar_discrepancy ='0' or Voter_id ='0' 
                                or ST_pass ='0' or Govt_schemes ='0' or income_increase ='0' or tools_required ='0' or social_service ='0') and users.role_id = 4 and users.district_id = $District_id
                                group by users.name, users.id
                                ORDER BY `total` DESC"));
        }

        else
        {
            $district= district::all();
            $userCount = DB::table("users")
                        ->leftjoin('details_of_citizens','details_of_citizens.created_by','=','users.id')
                        ->select('name','district_id', 'users.id', DB::raw('count(details_of_citizens.created_by) as total'))
                        ->where('users.role_id','4')
                        ->groupBy('name','district_id','users.id')
                        ->orderBy('total','DESC')
                        ->get();
            $Incomplete_Entries = DB::select(
                    DB::raw("SELECT users.name as Name, users.id as UID, COUNT(details_of_citizens.created_by) as total 
                                FROM `details_of_citizens`
                                left join users on (details_of_citizens.created_by = users.id)
                                where (any_disease ='0' or Regular_check_up ='0' or are_you_handicapped ='0' or aadhar_card ='0' or aadhar_discrepancy ='0' or Voter_id ='0' 
                                or ST_pass ='0' or Govt_schemes ='0' or income_increase ='0' or tools_required ='0' or social_service ='0') and users.role_id = 4
                                group by users.name, users.id 
                                ORDER BY `total` DESC"));  
        }
        return view ('District_wise_Entries',compact('userCount','district','Incomplete_Entries'));
    }

    public function UserWiseEntries()
    {
        if(Auth::user()->role_id == '1' || Auth::user()->role_id == '2' || Auth::user()->role_id == '3')
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
        
            if( Auth::user()->district_id == '')
            {
                $district_count = $this->AllDistrict();
                $userCount = DB::table("users")
                        ->leftjoin('details_of_citizens','details_of_citizens.created_by','=','users.id')
                        ->select('name','district_id', 'users.id' ,DB::raw('count(details_of_citizens.created_by) as total'))
                        ->where('users.role_id','4')
                        ->groupBy('name','district_id','users.id')
                        ->orderBy('total','DESC')
                        ->get(); 

                $Incomplete_Entries = DB::select(
                    DB::raw("SELECT users.name as Name, users.id as UID, COUNT(details_of_citizens.created_by) as total 
                                FROM `details_of_citizens`
                                left join users on (details_of_citizens.created_by = users.id)
                                where (any_disease ='0' or Regular_check_up ='0' or are_you_handicapped ='0' or aadhar_card ='0' or aadhar_discrepancy ='0' or Voter_id ='0' 
                                or ST_pass ='0' or Govt_schemes ='0' or income_increase ='0' or tools_required ='0' or social_service ='0') and users.role_id = 4
                                group by users.name, users.id
                                ORDER BY `total` DESC"));  
            }
            elseif(Auth::user()->taluka_id == '')
            {
                $AuthDist = Auth::user()->district_id;
                $district_count = $this->AllTaluka(Auth::user()->district_id);
                $userCount = DB::table("users")
                        ->leftjoin('details_of_citizens','details_of_citizens.created_by','=','users.id')
                        ->select('name', 'users.id', DB::raw('count(details_of_citizens.created_by) as total'))
                        ->where('users.role_id','4')
                        ->where('users.district_id', Auth::user()->district_id)
                        ->groupBy('name','users.id')
                        ->orderBy('total','DESC')
                        ->get();
                $Incomplete_Entries = DB::select(
                    DB::raw("SELECT users.name as Name, users.id as UID, COUNT(details_of_citizens.created_by) as total 
                                FROM `details_of_citizens`
                                left join users on (details_of_citizens.created_by = users.id)
                                where (any_disease ='0' or Regular_check_up ='0' or are_you_handicapped ='0' or aadhar_card ='0' or aadhar_discrepancy ='0' or Voter_id ='0' 
                                or ST_pass ='0' or Govt_schemes ='0' or income_increase ='0' or tools_required ='0' or social_service ='0') and users.role_id = 4 and users.district_id = $AuthDist
                                group by users.name, users.id
                                ORDER BY `total` DESC"));
            }
            else
            {
                $AuthTaluka = Auth::user()->taluka_id;
                $district_count = $this->CountVillage(Auth::user()->taluka_id);
                $userCount = DB::table("users")
                        ->leftjoin('details_of_citizens','details_of_citizens.created_by','=','users.id')
                        ->select('name', 'users.id' ,DB::raw('count(details_of_citizens.created_by) as total'))
                        ->where('users.role_id','!=','3')
                        ->where('users.district_id', Auth::user()->district_id)
                        ->groupBy('name','users.id')
                        ->orderBy('total','DESC')
                        ->get();
                $Incomplete_Entries = DB::select(
                    DB::raw("SELECT users.name as Name, users.id as UID, COUNT(details_of_citizens.created_by) as total 
                                FROM `details_of_citizens`
                                left join users on (details_of_citizens.created_by = users.id)
                                where (any_disease ='0' or Regular_check_up ='0' or are_you_handicapped ='0' or aadhar_card ='0' or aadhar_discrepancy ='0' or Voter_id ='0' 
                                or ST_pass ='0' or Govt_schemes ='0' or income_increase ='0' or tools_required ='0' or social_service ='0') and users.role_id = 4 and users.taluka_id = $AuthTaluka
                                group by users.name, users.id
                                ORDER BY `total` DESC"));
            }    

            return view ('UserWiseEntries',compact('district','userCount','Incomplete_Entries'));
        }
        else
        {
            return view ('Unauth');
        }
    }

    public function Incomplete_Entries()
    {
        if(Auth::user()->role_id == '1' || Auth::user()->role_id == '2')
        {   
            $Incomplete_Entries = DB::select(
                    DB::raw("SELECT talukas.taluka_name as Name, users.name, COUNT(details_of_citizens.created_by) as total
                                FROM `details_of_citizens`
                                left join users on (details_of_citizens.created_by = users.id) 
                                Right JOIN talukas ON (details_of_citizens.Taluka = talukas.id)
                                where any_disease ='0' or Regular_check_up ='0' or are_you_handicapped ='0' or aadhar_card ='0' or aadhar_discrepancy ='0' 
                                or Voter_id ='0' or ST_pass ='0' or Govt_schemes ='0' or income_increase ='0' 
                                or tools_required ='0' or social_service ='0'
                                group by talukas.taluka_name, users.name  
                                ORDER BY `total` DESC"));  
            return view ('Incomplete_entries',compact('Incomplete_Entries'));
        }
        else
        {
            return view ('Unauth');
        }
    }






    public function district_count($id)
    {        
        $taluka = taluka::all();
        $village = village::all();
        if($id>0)
        {
            $taluka_count = $this->AllTaluka($id);
            $Incomplete_Entries = DB::select(
                    DB::raw("SELECT talukas.taluka_name as Name, talukas.id ,COUNT(details_of_citizens.created_by) as total
                                FROM `details_of_citizens`
                                RIGHT JOIN talukas ON (details_of_citizens.Taluka = talukas.id)
                                where (any_disease ='0' or Regular_check_up ='0' or are_you_handicapped ='0' or aadhar_card ='0' or aadhar_discrepancy ='0' 
                                or Voter_id ='0' or ST_pass ='0' or Govt_schemes ='0' or income_increase ='0' 
                                or tools_required ='0' or social_service ='0') and
                                talukas.district_id = $id
                                group by talukas.taluka_name, talukas.id
                                ORDER BY `total` DESC"));
        }
        else
        {
            if( Auth::user()->district_id == '')
            {
                $taluka_count = $this->AllDistrict();
                $Incomplete_Entries = DB::select(
                    DB::raw("SELECT districts.name_of_district as Name, districts.id ,COUNT(details_of_citizens.created_by) as total
                                FROM `details_of_citizens`
                                Right JOIN districts ON (details_of_citizens.District = districts.id)
                                where any_disease ='0' or Regular_check_up ='0' or are_you_handicapped ='0' or aadhar_card ='0' 
                                or aadhar_discrepancy ='0' or Voter_id ='0' or ST_pass ='0' or Govt_schemes ='0' 
                                or income_increase ='0' or tools_required ='0' or social_service ='0'
                                group by districts.name_of_district, districts.id
                                ORDER BY `total` DESC"));  
            }
            else
            {
                $taluka_count =  $this->AllTaluka($id);
                $Incomplete_Entries = DB::select(
                    DB::raw("SELECT talukas.taluka_name as Name, talukas.id ,COUNT(details_of_citizens.created_by) as total
                                FROM `details_of_citizens`
                                RIGHT JOIN talukas ON (details_of_citizens.Taluka = talukas.id)
                                where (any_disease ='0' or Regular_check_up ='0' or are_you_handicapped ='0' or aadhar_card ='0' or aadhar_discrepancy ='0' 
                                or Voter_id ='0' or ST_pass ='0' or Govt_schemes ='0' or income_increase ='0' 
                                or tools_required ='0' or social_service ='0') and
                                talukas.district_id = $id
                                group by talukas.taluka_name, talukas.id
                                ORDER BY `total` DESC"));
            }
        }
        return view('ListDivisionalDashboard',compact('taluka_count','taluka','village','Incomplete_Entries'));
    }

    public function taluka_count($id,$districtID)
    {
        if($id>0)
        {
            $taluka_count = $this->CountVillage($id);
            $Incomplete_Entries = DB::select(
                    DB::raw("SELECT villages.name_of_village as Name, villages.id, COUNT(details_of_citizens.created_by) as total
                        FROM `details_of_citizens`
                        RIGHT JOIN villages ON (details_of_citizens.Village = villages.id)
                        where (any_disease ='0' or Regular_check_up ='0' or are_you_handicapped ='0' or aadhar_card ='0' or aadhar_discrepancy ='0' 
                        or Voter_id ='0' or ST_pass ='0' or Govt_schemes ='0' or income_increase ='0' 
                        or tools_required ='0' or social_service ='0') and
                        villages.Taluka_id = $id
                        group by villages.name_of_village, villages.id
                        ORDER BY `total` DESC"));
        }
        else
        {
            $taluka_count =  $this->AllTaluka($districtID);
            $Incomplete_Entries = DB::select(
                    DB::raw("SELECT talukas.taluka_name as Name, talukas.id ,COUNT(details_of_citizens.created_by) as total
                                FROM `details_of_citizens`
                                RIGHT JOIN talukas ON (details_of_citizens.Taluka = talukas.id)
                                where (any_disease ='0' or Regular_check_up ='0' or are_you_handicapped ='0' or aadhar_card ='0' or aadhar_discrepancy ='0' 
                                or Voter_id ='0' or ST_pass ='0' or Govt_schemes ='0' or income_increase ='0' 
                                or tools_required ='0' or social_service ='0') and
                                talukas.district_id = $districtID
                                group by talukas.taluka_name, talukas.id
                                ORDER BY `total` DESC")); 
        }   
        
        return view('ListDivisionalDashboard',compact('taluka_count','Incomplete_Entries'));
    }

    public function EducationCount()
    {
        $Education = DB::table("education")
                    ->where('Active','1')
                    ->get();
        $EducationCount = DB::table("details_of_citizens")
                            ->join('education','education.id','=','details_of_citizens.Education')
                            ->select('education.name_of_degree', DB::raw('count(*) as total'))
                            ->groupBy('name_of_degree')
                            ->orderBy('total','DESC')
                            ->get();
        return view('EducationWise',compact('Education','EducationCount'));
    }

    public function AllTaluka($districtID)
    {
        return $taluka_count = DB::table('talukas')
                                    ->where('district_id',$districtID)
                                    ->Leftjoin('details_of_citizens','details_of_citizens.Taluka','=','talukas.id')
                                    ->select('taluka_name as name', 'talukas.id as VID', DB::raw('count(details_of_citizens.Taluka) as total'))
                                    ->groupBy('talukas.taluka_name','talukas.id')
                                    ->orderBy('total','DESC')
                                    ->get();
    }

    public function AllDistrict()
    {
        return $taluka_count = DB::table('districts')
                        ->Leftjoin('details_of_citizens','details_of_citizens.District','=','districts.id')
                        ->select('name_of_district as name','districts.id as VID', DB::raw('count(details_of_citizens.District) as total'))
                        ->groupBy('districts.name_of_district','districts.id')
                        ->orderBy('total','DESC')
                        ->get();
    }

    public function CountVillage($id)
    {
        return $taluka_count = DB::table('villages')
                    ->where('Taluka_id',$id)
                    ->Leftjoin('details_of_citizens','details_of_citizens.Village','=','villages.id')
                    ->select('name_of_village as name','villages.id as VID', DB::raw('count(details_of_citizens.Village) as total'))
                    ->groupBy('name_of_village','villages.id')
                    ->orderBy('total','DESC')
                    ->get();   
    }    








    public function Village_wise_Education($talukaID)
    {
        if($talukaID>0)
        {
            $district = DB::table("villages")
                ->select('villages.name_of_village as Name','villages.id','villages.District_id','villages.Taluka_id')
                ->where('Taluka_id',$talukaID)
                ->where('Active','1')
                ->get();
            
            $education_count =  DB::select(
                            DB::raw("SELECT education.name_of_degree, details_of_citizens.Village as District, details_of_citizens.Education, count(*) as total 
                            FROM details_of_citizens
                            INNER JOIN education ON (education.id = details_of_citizens.Education)
                            where Taluka = $talukaID
                            GROUP BY details_of_citizens.Village, education.name_of_degree, details_of_citizens.Education"));
        }
        else
        {
            $district = DB::table("talukas")
                ->select('talukas.taluka_name as Name','talukas.id','talukas.District_id')
                ->where('District_id',Auth::user()->district_id)
                ->where('Active','1')
                ->get();
            
            $education_count =  DB::select(
                            DB::raw("SELECT education.name_of_degree, details_of_citizens.Taluka as District, details_of_citizens.Education, count(*) as total 
                                    FROM details_of_citizens
                                    INNER JOIN education ON (education.id = details_of_citizens.Education) 
                                    GROUP BY details_of_citizens.Taluka, education.name_of_degree, details_of_citizens.Education"));
        }

        $education = DB::table("education")
                ->where('Active','1')
                ->orderBy('sequence')
                ->get();

        return view ('EducationWise2',compact('education','education_count','district'));
    }

    public function district_wise_education($districtID)
    {
        if($districtID > 0)
        {
            $district = DB::table("talukas")
                ->select('talukas.taluka_name as Name','talukas.id','talukas.District_id')
                ->where('District_id',$districtID)
                ->where('Active','1')
                ->get();
            
            $education_count =  DB::select(
                        DB::raw("SELECT education.name_of_degree, details_of_citizens.Taluka as District, details_of_citizens.Education, count(*) as total 
                                FROM details_of_citizens
                                INNER JOIN education ON (education.id = details_of_citizens.Education)
                                where details_of_citizens.District = $districtID 
                                GROUP BY details_of_citizens.Taluka, education.name_of_degree, details_of_citizens.Education"));
        }

        else
        {
            $district= DB::table("districts")
                ->select('districts.name_of_district as Name','districts.id')
                ->where('Active','1')
                ->get();

            $education_count =  DB::select(
                            DB::raw("SELECT education.name_of_degree, details_of_citizens.District, details_of_citizens.Education, count(*) as total 
                            FROM details_of_citizens 
                            INNER JOIN education ON (education.id = details_of_citizens.Education) 
                            GROUP BY details_of_citizens.District, education.name_of_degree, details_of_citizens.Education"));
        }
        
        $education = DB::table("education")
                ->where('Active','1')
                ->orderBy('sequence')
                ->get();

        return view ('EducationWise2',compact('education','education_count','district'));
    }

    public function Taluka_education($talukaID,$districtID)
    {   
        if($talukaID > 0)
        {
            $district = DB::table("villages")
                ->select('villages.name_of_village as Name','villages.id','villages.District_id','villages.Taluka_id')
                ->where('Taluka_id',$talukaID)
                ->where('Active','1')
                ->get();
            
            $education_count =  DB::select(
                        DB::raw("SELECT education.name_of_degree, details_of_citizens.Village as District, details_of_citizens.Education, count(*) as total 
                                FROM details_of_citizens
                                INNER JOIN education ON (education.id = details_of_citizens.Education)
                                where details_of_citizens.Taluka = $talukaID
                                GROUP BY details_of_citizens.Village, education.name_of_degree, details_of_citizens.Education"));
        }
        else
        {
            $district = DB::table("talukas")
                ->select('talukas.taluka_name as Name','talukas.id','talukas.District_id')
                ->where('District_id',$districtID)
                ->where('Active','1')
                ->get();

            $education_count =  DB::select(
                        DB::raw("SELECT education.name_of_degree, details_of_citizens.Taluka as District, details_of_citizens.Education, count(*) as total 
                                FROM details_of_citizens
                                INNER JOIN education ON (education.id = details_of_citizens.Education)
                                where details_of_citizens.District = $districtID
                                GROUP BY details_of_citizens.Taluka, education.name_of_degree, details_of_citizens.Education"));
        }

        $education = DB::table("education")
                ->where('Active','1')
                ->orderBy('sequence')
                ->get();

        return view ('EducationWise2',compact('education','education_count','district'));
    }









    public function Village_OwnHouseYN($Taluka_id)
    {
        if($Taluka_id>0)
        {
            $district=  DB::table("villages")
                ->where("villages.id",$Taluka_id)
                ->get();
        
            $AuthTaluka = Auth::user()->taluka_id;
            $Own_House_YN = DB::select(
            DB::raw("SELECT villages.name_of_village as Name,
                            count( case when details_of_citizens.Own_house = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.Own_house = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative
                        FROM `villages`
                        Left join details_of_citizens on (villages.id = details_of_citizens.village)
                        where villages.Active = 1 and villages.Taluka_id = $Taluka_id
                        group by villages.name_of_village"));
        }

        else
        {
            $district=  DB::table("talukas")
                ->select('talukas.taluka_name as Name','talukas.id')
                ->where("district_id",Auth::user()->district_id)
                ->get(); 
            
            $AuthDist = Auth::user()->district_id;
            $Own_House_YN = DB::select(
                        DB::raw("SELECT talukas.taluka_name as Name,
                            count( case when details_of_citizens.Own_house = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.Own_house = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative
                        FROM `talukas`
                        Left join details_of_citizens on (talukas.id = details_of_citizens.Taluka)
                        where talukas.Active = 1 and talukas.district_id = $AuthDist
                        group by talukas.taluka_name"));
        }
        return view('Own_House_YN',compact('Own_House_YN','district'));
    }

    public function Taluka_OwnHouseYN($districtID)
    {
        if($districtID > 0)
        {
            $district = DB::table("talukas")
                ->select('talukas.taluka_name as Name','talukas.id','talukas.District_id')
                ->where('District_id',$districtID)
                ->where('Active','1')
                ->get();
            
            $Own_House_YN = DB::select(
                        DB::raw("SELECT talukas.taluka_name as Name,
                            count( case when details_of_citizens.Own_house = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.Own_house = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative
                        FROM `talukas`
                        Left join details_of_citizens on (talukas.id = details_of_citizens.Taluka)
                        where talukas.Active = 1 and talukas.district_id = $districtID
                        group by talukas.taluka_name"));
        }

        else
        {
            $district= district::all();
            $Own_House_YN = DB::select(
                    DB::raw("SELECT districts.name_of_district as Name,
                            count( case when details_of_citizens.Own_house = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.Own_house = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative
                        FROM `districts`
                        Left join details_of_citizens on (districts.id = details_of_citizens.District)
                        where districts.Active = 1
                        group by districts.name_of_district"));
        }

        return view('Own_House_YN',compact('Own_House_YN','district'));
    }






    public function Taluka_Home_Type_Wise($District_id)
    {
            if($District_id>0)
            {
                $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",$District_id)
                    ->get();

                $home_count = DB::table('details_of_citizens')
                        ->Join('home_types','home_types.id','=','details_of_citizens.home_type')
                        ->select('home_types.id','home_types.type_of_home', 'details_of_citizens.Taluka as District', 'details_of_citizens.home_type', DB::raw('count(details_of_citizens.Taluka) as total'))
                        ->where("District",$District_id)
                        ->groupBy('home_types.id','details_of_citizens.Taluka', 'home_types.type_of_home', 'details_of_citizens.home_type')
                        ->get();
            }

            else
            {         
                $district=  DB::table("districts")
                    ->select('districts.id as ID','districts.name_of_district as Name')
                    ->get();
                $home_count = DB::table('details_of_citizens')
                        ->Join('home_types','home_types.id','=','details_of_citizens.home_type')
                        ->select('home_types.id','home_types.type_of_home', 'details_of_citizens.District as District', 'details_of_citizens.home_type', DB::raw('count(details_of_citizens.District) as total'))
                        ->groupBy('home_types.id','details_of_citizens.District', 'home_types.type_of_home', 'details_of_citizens.home_type')
                        ->get();
            }
        
            $home_type = DB::table("home_types")
                        ->where('Active','1')
                        ->get();
            return view ('Home_type_wise',compact('district','home_count','home_type'));
    }

    public function District_Home_type_wise($districtID,$talukaID)
    {
        echo "districtID"." ".$districtID;
        echo "taluka"." ".$talukaID;
        if($talukaID > 0)
        {
            $district = DB::table("villages")
                ->select('villages.name_of_village as Name','villages.id as ID','villages.District_id','villages.Taluka_id')
                ->where('Taluka_id',$talukaID)
                ->where('Active','1')
                ->get();
            
            $home_count = DB::table('details_of_citizens')
                    ->Join('home_types','home_types.id','=','details_of_citizens.home_type')
                    ->select('home_types.id','home_types.type_of_home', 'details_of_citizens.Village as District', 'details_of_citizens.home_type', DB::raw('count(details_of_citizens.Village) as total'))
                    ->where("Taluka",$talukaID)
                    ->groupBy('home_types.id','details_of_citizens.Village', 'home_types.type_of_home', 'details_of_citizens.home_type')
                    ->get();
        }
        else
        {
            $district = DB::table("talukas")
                ->select('talukas.taluka_name as Name','talukas.id as ID','talukas.District_id')
                ->where('District_id',$districtID)
                ->where('Active','1')
                ->get();

            $home_count = DB::table('details_of_citizens')
                    ->Join('home_types','home_types.id','=','details_of_citizens.home_type')
                    ->select('home_types.id','home_types.type_of_home', 'details_of_citizens.Taluka as District', 'details_of_citizens.home_type', DB::raw('count(details_of_citizens.Taluka) as total'))
                    ->where("District",$districtID)
                    ->groupBy('home_types.id','details_of_citizens.Taluka', 'home_types.type_of_home', 'details_of_citizens.home_type')
                    ->get();
        }
        $home_type = DB::table("home_types")
                                ->where('Active','1')
                                ->get();

        return view ('Home_type_wise',compact('district','home_count','home_type'));
    }

    public function Village_Home_type_wise($Taluka_id)
    {
        if($Taluka_id>0)
        {
            $district = DB::table("villages")
                ->select('villages.name_of_village as Name','villages.id as ID','villages.District_id','villages.Taluka_id')
                ->where('Taluka_id',$Taluka_id)
                ->where('Active','1')
                ->get();
            
            $home_count = DB::table('details_of_citizens')
                    ->Join('home_types','home_types.id','=','details_of_citizens.home_type')
                    ->select('home_types.id','home_types.type_of_home', 'details_of_citizens.Village as District', 'details_of_citizens.home_type', DB::raw('count(details_of_citizens.Village) as total'))
                    ->where("Taluka",$Taluka_id)
                    ->groupBy('home_types.id','details_of_citizens.Village', 'home_types.type_of_home', 'details_of_citizens.home_type')
                    ->get();
        }
        else
        {
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",Auth::user()->district_id)
                    ->get();

            $home_count = DB::table('details_of_citizens')
                    ->Join('home_types','home_types.id','=','details_of_citizens.home_type')
                    ->select('home_types.id','home_types.type_of_home', 'details_of_citizens.Taluka as District', 'details_of_citizens.home_type', DB::raw('count(details_of_citizens.Taluka) as total'))
                    ->where("District",Auth::user()->district_id)
                    ->groupBy('home_types.id','details_of_citizens.Taluka', 'home_types.type_of_home', 'details_of_citizens.home_type')
                    ->get();
        }
        $home_type = DB::table("home_types")
                                ->where('Active','1')
                                ->get();

        return view ('Home_type_wise',compact('district','home_count','home_type'));
    }






    public function Taluka_stove_type_wise($DistrictID)
    {
        if($DistrictID>0)
        {
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",$DistrictID)
                    ->get();

            $StoveTypeWise = DB::select(
                            DB::raw("SELECT stove_types.type_of_stove, details_of_citizens.Taluka as District, details_of_citizens.stove_type, count(details_of_citizens.Taluka) as total
                            FROM details_of_citizens
                            INNER JOIN stove_types ON (stove_types.id = details_of_citizens.stove_type) 
                            where details_of_citizens.District = $DistrictID
                            GROUP BY details_of_citizens.Taluka, stove_types.type_of_stove, details_of_citizens.stove_type"));
        }
        else
        {
            $district=  DB::table("districts")
                    ->select('districts.id as ID','districts.name_of_district as Name')
                    ->get();
            
            $StoveTypeWise = DB::select(
                            DB::raw("SELECT stove_types.id, stove_types.type_of_stove, details_of_citizens.District, details_of_citizens.stove_type, count(details_of_citizens.District) as total
                            FROM details_of_citizens
                            INNER JOIN stove_types ON (stove_types.id = details_of_citizens.stove_type) WHERE Active = 1
                            GROUP BY details_of_citizens.District, stove_types.id, stove_types.type_of_stove, details_of_citizens.stove_type"));
        }

        $stove_type = DB::table("stove_types")
                    ->where('Active','1')
                    ->get();
        
        return view('Stove_type_wise',compact('district','stove_type','StoveTypeWise'));           
    }

    public function Village_stove_type_wise($talukaID)
    {
        if($talukaID>0)
        {
            $district = DB::table("villages")
                ->select('villages.name_of_village as Name','villages.id as ID','villages.District_id','villages.Taluka_id')
                ->where('Taluka_id',$talukaID)
                ->where('Active','1')
                ->get();
            
            $StoveTypeWise = DB::select(
                            DB::raw("SELECT stove_types.type_of_stove, details_of_citizens.Village as District, details_of_citizens.stove_type, count(details_of_citizens.Village) as total
                            FROM details_of_citizens
                            INNER JOIN stove_types ON (stove_types.id = details_of_citizens.stove_type) 
                            where details_of_citizens.Taluka = $talukaID
                            GROUP BY details_of_citizens.Village, stove_types.type_of_stove, details_of_citizens.stove_type"));
        }

        else
        {
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",Auth::user()->district_id)
                    ->get();

            $StoveTypeWise = DB::select(
                            DB::raw("SELECT stove_types.type_of_stove, details_of_citizens.Taluka as District, details_of_citizens.stove_type, count(details_of_citizens.Taluka) as total
                            FROM details_of_citizens
                            INNER JOIN stove_types ON (stove_types.id = details_of_citizens.stove_type) 
                            where details_of_citizens.Taluka = {{Auth::user()->district_id}}
                            GROUP BY details_of_citizens.Taluka, stove_types.type_of_stove, details_of_citizens.stove_type"));
        }
        $stove_type = DB::table("stove_types")
                    ->where('Active','1')
                    ->get();
        
        return view('Stove_type_wise',compact('district','stove_type','StoveTypeWise'));    
    }















    

    public function Taluka_Income_source_wise($DistrictID)
    {
        if($DistrictID > 0)
        {            
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",$DistrictID)
                    ->get();
            
            $income_source_wise = DB::select(
                    DB::raw("SELECT income_sources.type_of_income_source, details_of_citizens.Taluka as District, details_of_citizens.Income_source, count(details_of_citizens.Taluka) as total 
                    FROM details_of_citizens 
                    INNER JOIN income_sources ON (income_sources.id = details_of_citizens.Income_source) 
                    WHERE details_of_citizens.District =  $DistrictID
                    GROUP BY income_sources.type_of_income_source, details_of_citizens.Taluka, details_of_citizens.Income_source"));

        }

        else
        {
            $district=  DB::table("districts")
                    ->select('districts.id as ID','districts.name_of_district as Name')
                    ->get();
            
            $income_source_wise = DB::select(
                    DB::raw("SELECT income_sources.type_of_income_source, details_of_citizens.District, details_of_citizens.Income_source, count(details_of_citizens.District) as total 
                    FROM details_of_citizens 
                    INNER JOIN income_sources ON (income_sources.id = details_of_citizens.Income_source) 
                    GROUP BY income_sources.type_of_income_source, details_of_citizens.District, details_of_citizens.Income_source"));
        }

        $income_sources = DB::table("income_sources")
                    ->where('Active','1')
                    ->get();
        
        return view('Income_source_wise',compact('district','income_sources','income_source_wise'));
    }

    public function Village_Income_source_wise($talukaID)
    {
        if($talukaID > 0)
        {
            $district = DB::table("villages")
                ->select('villages.name_of_village as Name','villages.id as ID','villages.District_id','villages.Taluka_id')
                ->where('Taluka_id',$talukaID)
                ->where('Active','1')
                ->get();
            
            $income_source_wise = DB::select(
                    DB::raw("SELECT income_sources.type_of_income_source, details_of_citizens.Village as District, details_of_citizens.Income_source, count(details_of_citizens.Village) as total 
                    FROM details_of_citizens 
                    INNER JOIN income_sources ON (income_sources.id = details_of_citizens.Income_source) 
                    WHERE details_of_citizens.Taluka =  $talukaID
                    GROUP BY income_sources.type_of_income_source, details_of_citizens.Village, details_of_citizens.Income_source"));
        }
        else
        {
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",Auth::user()->district_id)
                    ->get();
            
            $income_source_wise = DB::select(
                    DB::raw("SELECT income_sources.type_of_income_source, details_of_citizens.Taluka as District, details_of_citizens.Income_source, count(details_of_citizens.Taluka) as total 
                    FROM details_of_citizens 
                    INNER JOIN income_sources ON (income_sources.id = details_of_citizens.Income_source) 
                    WHERE details_of_citizens.District =  {{Auth::user()->district_id}}
                    GROUP BY income_sources.type_of_income_source, details_of_citizens.Taluka, details_of_citizens.Income_source"));
        }

        $income_sources = DB::table("income_sources")
                    ->where('Active','1')
                    ->get();
        
        return view('Income_source_wise',compact('district','income_sources','income_source_wise'));
    }







    public function Taluka_Bank_YN($DistrictID)
    {
        if($DistrictID > 0)
        {
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",$DistrictID)
                    ->get();

            $Bank_YN = DB::select(
                    DB::raw("SELECT talukas.taluka_name as Name, 
                            count( case when details_of_citizens.Bank_account = 'Y'
                                        then 1 
                                end
                                ) as YES,
                            count( case when details_of_citizens.Bank_account = 'N'
                                        then 1 
                                end
                                ) as Negative
                        FROM `talukas`
                        Left join details_of_citizens on (talukas.id = details_of_citizens.Taluka)
                        where talukas.district_id = $DistrictID and talukas.Active = 1
                        group by talukas.taluka_name"));
        }
        else
        {
            $district=  DB::table("districts")
                    ->select('districts.id as ID','districts.name_of_district as Name')
                    ->get();
            
            $Bank_YN = DB::select(
                    DB::raw("SELECT districts.name_of_district as Name,
                        count( case when details_of_citizens.Bank_account = 'Y'
                                    then 1 
                            end
                            ) as YES,
                        count( case when details_of_citizens.Bank_account = 'N'
                                    then 1 
                            end
                            ) as Negative
                    FROM `districts`
                    Left join details_of_citizens on (districts.id = details_of_citizens.District)
                    group by districts.name_of_district"));
        }
        return view ('Bank_Account_YN',compact('Bank_YN','district'));
    }

    public function Village_Bank_YN($talukaID)
    {
        if($talukaID > 0)
        {
            $district = DB::table("villages")
                    ->select('villages.name_of_village as Name','villages.id as ID','villages.District_id','villages.Taluka_id')
                    ->where('Taluka_id',$talukaID)
                    ->where('Active','1')
                    ->get();
            
            $Bank_YN = DB::select(
                    DB::raw("SELECT villages.name_of_village as Name, 
                            count( case when details_of_citizens.Bank_account = 'Y'
                                        then 1 
                                end
                                ) as YES,
                            count( case when details_of_citizens.Bank_account = 'N'
                                        then 1 
                                end
                                ) as Negative
                        FROM `villages`
                        Left join details_of_citizens on (villages.id = details_of_citizens.Village)
                        where villages.Taluka_id = $talukaID and villages.Active = 1
                        group by villages.name_of_village"));
        }    
        else
        {
            $AuthTaluka = Auth::user()->taluka_id;
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",Auth::user()->taluka_id)
                    ->get();
            
            $Bank_YN = DB::select(
                    DB::raw("SELECT talukas.taluka_name as Name, 
                            count( case when details_of_citizens.Bank_account = 'Y'
                                        then 1 
                                end
                                ) as YES,
                            count( case when details_of_citizens.Bank_account = 'N'
                                        then 1 
                                end
                                ) as Negative
                        FROM `talukas`
                        Left join details_of_citizens on (talukas.id = details_of_citizens.Taluka)
                        where talukas.id = $AuthTaluka and talukas.Active = 1
                        group by talukas.taluka_name"));
        }
        return view ('Bank_Account_YN',compact('Bank_YN','district'));
    }






    public function Taluka_Bank_type_wise($DistrictID)
    {
        if($DistrictID > 0)
        {
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",$DistrictID)
                    ->get();
            
            $BankTypeWise = DB::select(
                    DB::raw("SELECT bank_types.type_of_bank, details_of_citizens.Taluka as District, details_of_citizens.Bank_type, count(*) as total 
                    FROM details_of_citizens 
                    INNER JOIN bank_types ON (bank_types.id = details_of_citizens.Bank_type)
                    WHERE details_of_citizens.District = $DistrictID
                    GROUP BY details_of_citizens.Taluka, bank_types.type_of_bank, details_of_citizens.bank_type"));
        }
        else
        {
            $district=  DB::table("districts")
                    ->select('districts.id as ID','districts.name_of_district as Name')
                    ->get();

            $BankTypeWise = DB::select(
                    DB::raw("SELECT bank_types.type_of_bank, details_of_citizens.District, details_of_citizens.Bank_type, count(*) as total 
                    FROM details_of_citizens 
                    INNER JOIN bank_types ON (bank_types.id = details_of_citizens.Bank_type)
                    GROUP BY details_of_citizens.District, bank_types.type_of_bank, details_of_citizens.bank_type"));
        }
        
        $bank_type = DB::table("bank_types")
                    ->where('Active','1')
                    ->get();
        
        return view ('Bank_type_Wise',compact('district','BankTypeWise','bank_type'));
    }

    public function Village_Bank_type_wise($talukaID)
    {
        if($talukaID > 0)
        {
            $district = DB::table("villages")
                    ->select('villages.name_of_village as Name','villages.id as ID','villages.District_id','villages.Taluka_id')
                    ->where('Taluka_id',$talukaID)
                    ->where('Active','1')
                    ->get();

            $BankTypeWise = DB::select(
                    DB::raw("SELECT bank_types.type_of_bank, details_of_citizens.Village as District, details_of_citizens.Bank_type, count(*) as total 
                    FROM details_of_citizens 
                    INNER JOIN bank_types ON (bank_types.id = details_of_citizens.Bank_type)
                    where details_of_citizens.Taluka = $talukaID
                    GROUP BY details_of_citizens.village, bank_types.type_of_bank, details_of_citizens.bank_type"));
        }
        else
        {
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",Auth::user()->district_id)
                    ->get();
            
            $BankTypeWise = DB::select(
                    DB::raw("SELECT bank_types.type_of_bank, details_of_citizens.Taluka as District, details_of_citizens.Bank_type, count(*) as total
                    FROM details_of_citizens
                    INNER JOIN bank_types ON (bank_types.id = details_of_citizens.Bank_type)
                    WHERE details_of_citizens.District = {{Auth::user()->district_id}}
                    GROUP BY details_of_citizens.Taluka, bank_types.type_of_bank, details_of_citizens.bank_type"));
        }
        $bank_type = DB::table("bank_types")
                    ->where('Active','1')
                    ->get();
        
        return view ('Bank_type_Wise',compact('district','BankTypeWise','bank_type'));
    }





    public function Taluka_WashroomWise($DistrictID)
    {
        if($DistrictID > 0)
        {
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",$DistrictID)
                    ->get();
            
            $washroomWise = DB::select(
                    DB::raw("SELECT talukas.taluka_name as Name, 
                            count( case when details_of_citizens.Water_closet = 'Y'
                                        then 1 
                                end
                                ) as YES,
                            count( case when details_of_citizens.Water_closet = 'N'
                                        then 1 
                                end
                                ) as Negative
                        FROM `talukas`
                        Left join details_of_citizens on (talukas.id = details_of_citizens.Taluka)
                        where talukas.district_id = $DistrictID and talukas.Active = 1
                        group by talukas.taluka_name"));
        }
        else
        {
            $district=  DB::table("districts")
                    ->select('districts.id as ID','districts.name_of_district as Name')
                    ->get();

            $washroomWise = DB::select(
                    DB::raw("SELECT districts.name_of_district as Name,
                        count( case when details_of_citizens.Water_closet = 'Y'
                                    then 1 
                            end
                            ) as YES,
                        count( case when details_of_citizens.Water_closet = 'N'
                                    then 1 
                            end
                            ) as Negative
                    FROM `districts`
                    Left join details_of_citizens on (districts.id = details_of_citizens.District)
                    group by districts.name_of_district"));

        }
        return view('Washroom_wise',compact('washroomWise','district'));   
    }

    public function Village_WashroomWise($talukaID)
    {
        if($talukaID > 0)
        {
            $district = DB::table("villages")
                ->select('villages.name_of_village as Name','villages.id as ID','villages.District_id','villages.Taluka_id')
                ->where('Taluka_id',$talukaID)
                ->where('Active','1')
                ->get();
            
            $washroomWise = DB::select(
                    DB::raw("SELECT villages.name_of_village as Name, 
                            count( case when details_of_citizens.Water_closet = 'Y'
                                        then 1 
                                end
                                ) as YES,
                            count( case when details_of_citizens.Water_closet = 'N'
                                        then 1 
                                end
                                ) as Negative,
                            COUNT( case when details_of_citizens.Water_closet = '0'
                                        then 1 
                                end
                                )as BLANK
                        FROM `villages`
                        Left join details_of_citizens on (villages.id = details_of_citizens.Village)
                        where villages.Taluka_id = $talukaID and villages.Active = 1
                        group by villages.name_of_village"));
        }
        return view('Washroom_wise',compact('washroomWise','district'));
    }






    public function Taluka_Bathroomwise($DistrictID)
    {
        if($DistrictID > 0)
        {
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",$DistrictID)
                    ->get();

            $bathroomwise = DB::select(
            DB::raw("SELECT talukas.taluka_name as Name, 
                            count( case when details_of_citizens.Bathroom = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.Bathroom = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative
                        FROM `talukas`
                        Left join details_of_citizens on (talukas.id = details_of_citizens.Taluka)
                        where talukas.Active = 1 and talukas.district_id = $DistrictID
                        group by talukas.taluka_name"));
        }
        else
        {
            $district=  DB::table("districts")
                    ->select('districts.id as ID','districts.name_of_district as Name')
                    ->get();
            
            $bathroomwise = DB::select(
                    DB::raw("SELECT districts.name_of_district as Name, 
                            count( case when details_of_citizens.Bathroom = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.Bathroom = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative
                        FROM `districts`
                        Left join details_of_citizens on (districts.id = details_of_citizens.District)
                        where districts.Active = 1 
                        group by districts.name_of_district"));
        }
        return view('Bathroom_wise',compact('bathroomwise','district'));
    }

    public function Village_Bathroomwise($talukaID)
    {
        if($talukaID > 0)
        {
            $district = DB::table("villages")
                ->select('villages.name_of_village as Name','villages.id as ID','villages.District_id','villages.Taluka_id')
                ->where('Taluka_id',$talukaID)
                ->where('Active','1')
                ->get();

            $bathroomwise = DB::select(
                    DB::raw("SELECT villages.name_of_village as Name, 
                            count( case when details_of_citizens.Bathroom = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.Bathroom = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative
                        FROM `villages`
                        Left join details_of_citizens on (villages.id = details_of_citizens.Village)
                        where villages.Active = 1 and villages.taluka_id = $talukaID
                        group by villages.name_of_village"));
        }
        return view('Bathroom_wise',compact('bathroomwise','district'));
    }






    

    public function Taluka_LandWise($DistrictID)
    {
        if($DistrictID > 0)
        {
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",$DistrictID)
                    ->get();

            $Landwise = DB::select(
            DB::raw("SELECT talukas.taluka_name as Name, 
                            count( case when details_of_citizens.Land_ownership = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.Land_ownership = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative
                        FROM `talukas`
                        Left join details_of_citizens on (talukas.id = details_of_citizens.Taluka)
                        where talukas.Active = 1 and talukas.district_id = $DistrictID
                        group by talukas.taluka_name"));
        }
        else
        {
            $district=  DB::table("districts")
                    ->select('districts.id as ID','districts.name_of_district as Name')
                    ->get();
            
            $Landwise = DB::select(
            DB::raw("SELECT districts.name_of_district as Name, 
                            count( case when details_of_citizens.Land_ownership = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.Land_ownership = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative
                        FROM `districts`
                        Left join details_of_citizens on (districts.id = details_of_citizens.District)
                        where districts.Active = 1 
                        group by districts.name_of_district"));
        }
        return view('LandWise',compact('Landwise','district'));
    }

    public function Village_LandWise($talukaID)
    {
        if($talukaID > 0)
        {
            $district = DB::table("villages")
                ->select('villages.name_of_village as Name','villages.id as ID','villages.District_id','villages.Taluka_id')
                ->where('Taluka_id',$talukaID)
                ->where('Active','1')
                ->get();

            $Landwise = DB::select(
            DB::raw("SELECT villages.name_of_village as Name, 
                            count( case when details_of_citizens.Land_ownership = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.Land_ownership = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative
                        FROM `villages`
                        Left join details_of_citizens on (villages.id = details_of_citizens.Village)
                        where villages.Active = 1 and villages.taluka_id = $talukaID
                        group by villages.name_of_village"));
        }
        return view('LandWise',compact('Landwise','district'));
    }





    public function Taluka_Land_Dispute($DistrictID)
    {
        if($DistrictID > 0)
        {
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",$DistrictID)
                    ->get();
            
            $LandDisputewise = DB::select(
            DB::raw("SELECT talukas.taluka_name as Name, 
                            count( case when details_of_citizens.Land_dispute = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.Land_dispute = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative
                        FROM `talukas`
                        Left join details_of_citizens on (talukas.id = details_of_citizens.Taluka)
                        where talukas.Active = 1 and talukas.district_id = $DistrictID and details_of_citizens.Land_ownership = 'Y'
                        group by talukas.taluka_name"));
        }
        else
        {
            $district=  DB::table("districts")
                    ->select('districts.id as ID','districts.name_of_district as Name')
                    ->get();

            $LandDisputewise = DB::select(
                    DB::raw("SELECT districts.name_of_district as Name, 
                            count( case when details_of_citizens.Land_dispute = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.Land_dispute = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative
                        FROM `districts`
                        Left join details_of_citizens on (districts.id = details_of_citizens.District)
                        where districts.Active = 1 and details_of_citizens.Land_ownership = 'Y'
                        group by districts.name_of_district"));
        }
        return view('Land_Dispute',compact('LandDisputewise','district'));
    }

    public function Village_Land_Dispute($talukaID)
    {
        if($talukaID > 0)
        {
            $district = DB::table("villages")
                ->select('villages.name_of_village as Name','villages.id as ID','villages.District_id','villages.Taluka_id')
                ->where('Taluka_id',$talukaID)
                ->where('Active','1')
                ->get();
            
            $LandDisputewise = DB::select(
            DB::raw("SELECT villages.name_of_village as Name, 
                            count( case when details_of_citizens.Land_dispute = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.Land_dispute = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative
                        FROM `villages`
                        Left join details_of_citizens on (villages.id = details_of_citizens.Village)
                        where villages.Active = 1 and villages.taluka_id = $talukaID and details_of_citizens.Land_ownership = 'Y'
                        group by villages.name_of_village"));
        }
        return view('Land_Dispute',compact('LandDisputewise','district'));
    }




    

    public function Taluka_Member($DistrictID)
    {
        if($DistrictID > 0)
        {
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",$DistrictID)
                    ->get();
            
            $count = DB::select(
                    DB::raw("select talukas.id as District_ID, count(details_of_citizens.Taluka) as totalCount
                    From talukas
                    INNER JOIN details_of_citizens ON (details_of_citizens.Taluka = talukas.id)
                    where talukas.district_id = $DistrictID
                    group By talukas.id, details_of_citizens.District"));
            
            $member_count = DB::select(
                    DB::raw("SELECT members.lives_with_you, talukas.id as District_id, COUNT(distinct members.Citizen_id) as total
                            FROM details_of_citizens 
                            Right join talukas ON (details_of_citizens.Taluka = talukas.id)
                            RIGHT JOIN members ON (details_of_citizens.id = members.Citizen_id)
                            where members.lives_with_you = 'Y' and talukas.district_id = $DistrictID
                            GROUP BY talukas.id, members.lives_with_you"));
        }
        else
        {
            $district=  DB::table("districts")
                    ->select('districts.id as ID','districts.name_of_district as Name')
                    ->get();

            $count = DB::select(
                    DB::raw("select districts.id as District_ID, count(details_of_citizens.District) as totalCount
                    From districts
                    INNER JOIN details_of_citizens ON (details_of_citizens.District = districts.id) 
                    group By districts.id, details_of_citizens.District"));

        
            $member_count = DB::select(
                    DB::raw("SELECT members.lives_with_you, districts.id as District_id, COUNT(distinct members.Citizen_id) as total
                            FROM details_of_citizens 
                            Right join districts ON (details_of_citizens.District = districts.id)
                            RIGHT JOIN members ON (details_of_citizens.id = members.Citizen_id)
                            where members.lives_with_you = 'Y'
                            GROUP BY districts.id, members.lives_with_you"));
        }
        return view('Members',compact('member_count','district','count'));
    }

    public function Village_Member($talukaID)
    {
        if($talukaID > 0)
        {
            $district = DB::table("villages")
                ->select('villages.name_of_village as Name','villages.id as ID','villages.District_id','villages.Taluka_id')
                ->where('Taluka_id',$talukaID)
                ->where('Active','1')
                ->get();

            $count = DB::select(
                    DB::raw("select villages.id as District_ID, count(details_of_citizens.Village) as totalCount
                    From villages
                    INNER JOIN details_of_citizens ON (details_of_citizens.Village = villages.id) 
                    where villages.Taluka_id = $talukaID
                    group By villages.id, details_of_citizens.Village"));

        
            $member_count = DB::select(
                    DB::raw("SELECT members.lives_with_you, villages.id as District_id, COUNT(distinct members.Citizen_id) as total
                            FROM details_of_citizens 
                            Right join villages ON (details_of_citizens.Village = villages.id)
                            RIGHT JOIN members ON (details_of_citizens.id = members.Citizen_id)
                            where members.lives_with_you = 'Y' and details_of_citizens.Taluka = $talukaID
                            GROUP BY villages.id, members.lives_with_you"));
        }
        return view('Members',compact('member_count','district','count'));
    }







    

    public function Taluka_Regular_CheckUp($DistrictID)
    {
        if($DistrictID > 0)
        {
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",$DistrictID)
                    ->get();
                
            $RegularCheckupWise = DB::select(
                DB::raw("SELECT talukas.taluka_name as Name, 
                            count( case when details_of_citizens.Regular_check_up = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.Regular_check_up = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative,
                            count( case when details_of_citizens.Regular_check_up = '0'
                                        then 1 
                                        else Null
                                end
                                ) as BLANK
                        FROM `talukas`
                        Left join details_of_citizens on (talukas.id = details_of_citizens.Taluka)
                        where talukas.Active = 1 and talukas.district_id = $DistrictID
                        group by talukas.taluka_name"));
        }
        else
        {
            $district=  DB::table("districts")
                    ->select('districts.id as ID','districts.name_of_district as Name')
                    ->get();

            $RegularCheckupWise =  DB::select(
                    DB::raw("SELECT districts.name_of_district as Name, 
                            count( case when details_of_citizens.Regular_check_up = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.Regular_check_up = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative,
                            count( case when details_of_citizens.Regular_check_up = '0'
                                        then 1 
                                        else Null
                                end
                                )as BLANK
                        FROM `districts`
                        Left join details_of_citizens on (districts.id = details_of_citizens.District)
                        where districts.Active = 1 
                        group by districts.name_of_district"));
        }
        return view('Regular_CheckUp_Dashboard',compact('RegularCheckupWise','district'));
    }
    
    public function Village_Regular_CheckUp($talukaID)
    {
        if($talukaID>0)
        {
            $district = DB::table("villages")
                ->select('villages.name_of_village as Name','villages.id as ID','villages.District_id','villages.Taluka_id')
                ->where('Taluka_id',$talukaID)
                ->where('Active','1')
                ->get();

            $RegularCheckupWise = DB::select(
            DB::raw("SELECT villages.name_of_village as Name, 
                            count( case when details_of_citizens.Regular_check_up = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.Regular_check_up = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative,
                            count( case when details_of_citizens.Regular_check_up = '0'
                                        then 1 
                                        else Null
                                end
                                ) as BLANK
                        FROM `villages`
                        Left join details_of_citizens on (villages.id = details_of_citizens.Village)
                        where villages.Active = 1 and villages.taluka_id = $talukaID
                        group by villages.name_of_village"));
        }
        return view('Regular_CheckUp_Dashboard',compact('RegularCheckupWise','district'));
    }





    

    public function Taluka_DiseaseYN($DistrictID)
    {
        if($DistrictID > 0)
        {
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",$DistrictID)
                    ->get();
            
            $Disease_YN = DB::select(
            DB::raw("SELECT talukas.taluka_name as Name, 
                            count( case when details_of_citizens.any_disease = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.any_disease = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative,
                            count( case when details_of_citizens.any_disease = '0'
                                        then 1 
                                        else Null
                                end
                                ) as BLANK
                        FROM `talukas`
                        Left join details_of_citizens on (talukas.id = details_of_citizens.Taluka)
                        where talukas.Active = 1 and talukas.district_id = $DistrictID
                        group by talukas.taluka_name"));
        }
        else
        {
            $district=  DB::table("districts")
                    ->select('districts.id as ID','districts.name_of_district as Name')
                    ->get();
            
            $Disease_YN =DB::select(
            DB::raw("SELECT districts.name_of_district as Name, 
                            count( case when details_of_citizens.any_disease = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.any_disease = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative,
                            count( case when details_of_citizens.any_disease = '0'
                                        then 1 
                                        else Null
                                end
                                )as BLANK
                        FROM `districts`
                        Left join details_of_citizens on (districts.id = details_of_citizens.District)
                        where districts.Active = 1 
                        group by districts.name_of_district"));
        }
        return view('DiseaseYN',compact('Disease_YN','district'));
    }

    public function Village_DiseaseYN($talukaID)
    {
        if($talukaID > 0)
        {
            $district = DB::table("villages")
                ->select('villages.name_of_village as Name','villages.id as ID','villages.District_id','villages.Taluka_id')
                ->where('Taluka_id',$talukaID)
                ->where('Active','1')
                ->get();

            $Disease_YN = DB::select(
            DB::raw("SELECT villages.name_of_village as Name, 
                            count( case when details_of_citizens.any_disease = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.any_disease = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative,
                            count( case when details_of_citizens.any_disease = '0'
                                        then 1 
                                        else Null
                                end
                                ) as BLANK
                        FROM `villages`
                        Left join details_of_citizens on (villages.id = details_of_citizens.Village)
                        where villages.Active = 1 and villages.taluka_id = $talukaID
                        group by villages.name_of_village"));
        }
        return view('DiseaseYN',compact('Disease_YN','district'));
    }






    

    public function Taluka_DiseaseWise($DistrictID)
    {
        if($DistrictID > 0)
        {
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",$DistrictID)
                    ->get();

            $Disease_wise = DB::select(
                    DB::raw("SELECT details_of_citizens.Taluka as District, Disease_id ,count(citizen_diseases.id) as total 
                    FROM `citizen_diseases` 
                    INNER JOIN details_of_citizens ON (details_of_citizens.id = citizen_diseases.Citizen_id)
                    where  details_of_citizens.District = $DistrictID
                    group By details_of_citizens.Taluka, Disease_id"));
        }
        else
        {
            $district=  DB::table("districts")
                    ->select('districts.id as ID','districts.name_of_district as Name')
                    ->get();
            
            $Disease_wise = DB::select(
                    DB::raw("SELECT details_of_citizens.District, Disease_id ,count(citizen_diseases.id) as total 
                    FROM `citizen_diseases` 
                    INNER JOIN details_of_citizens ON (details_of_citizens.id = citizen_diseases.Citizen_id) 
                    group By details_of_citizens.District, Disease_id"));
        }
        $diseases = DB::table("diseases")
                    ->where('Active','1')
                    ->get();
        
        return view('DiseaseWise',compact('diseases','Disease_wise','district'));
    }

    public function Village_DiseaseWise($talukaID)
    {
        if($talukaID > 0)
        {
            $district = DB::table("villages")
                    ->select('villages.name_of_village as Name','villages.id as ID','villages.District_id','villages.Taluka_id')
                    ->where('Taluka_id',$talukaID)
                    ->where('Active','1')
                    ->get();
            
            $Disease_wise = DB::select(
                        DB::raw("SELECT details_of_citizens.Village as District, Disease_id ,count(citizen_diseases.id) as total 
                        FROM `citizen_diseases` 
                        INNER JOIN details_of_citizens ON (details_of_citizens.id = citizen_diseases.Citizen_id)
                        where  details_of_citizens.Taluka = $talukaID
                        group By details_of_citizens.Village, Disease_id"));
        }
        $diseases = DB::table("diseases")
                    ->where('Active','1')
                    ->get();
        
        return view('DiseaseWise',compact('diseases','Disease_wise','district'));
    }





    
    public function Taluka_Hospital_type_wise($DistrictID)
    {
        if($DistrictID > 0)
        {
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",$DistrictID)
                    ->get();
         
            $Hospital_Type_Wise = DB::select(
                    DB::raw("SELECT hospital_types.type_of_hospital, details_of_citizens.Taluka as District, details_of_citizens.Hospital_type, count(*) as total 
                    FROM details_of_citizens 
                    INNER JOIN hospital_types ON (hospital_types.id = details_of_citizens.Hospital_type) 
                    WHERE Active = 1 and details_of_citizens.District = $DistrictID
                    GROUP BY hospital_types.type_of_hospital, details_of_citizens.Taluka, details_of_citizens.Hospital_type"));
        }
        else
        {
            $district=  DB::table("districts")
                    ->select('districts.id as ID','districts.name_of_district as Name')
                    ->get();

            $Hospital_Type_Wise = DB::select(
                    DB::raw("SELECT hospital_types.type_of_hospital, details_of_citizens.District, details_of_citizens.Hospital_type, count(*) as total 
                    FROM details_of_citizens 
                    INNER JOIN hospital_types ON (hospital_types.id = details_of_citizens.Hospital_type) WHERE Active = 1 
                    GROUP BY hospital_types.type_of_hospital, details_of_citizens.District, details_of_citizens.Hospital_type"));
        }
        $Hospital_type = DB::table('hospital_types')
                    ->where('Active','1')
                    ->get();

        return view('Hospital_type_wise',compact('Hospital_type','Hospital_Type_Wise','district')); 
    }

    public function Village_Hospital_type_wise($talukaID)
    {
        if($talukaID > 0)
        {
            $district = DB::table("villages")
                ->select('villages.name_of_village as Name','villages.id as ID','villages.District_id','villages.Taluka_id')
                ->where('Taluka_id',$talukaID)
                ->where('Active','1')
                ->get();

            $Hospital_Type_Wise = DB::select(
                    DB::raw("SELECT hospital_types.type_of_hospital, details_of_citizens.Village as District, details_of_citizens.Hospital_type, count(*) as total 
                    FROM details_of_citizens 
                    INNER JOIN hospital_types ON (hospital_types.id = details_of_citizens.Hospital_type) WHERE Active = 1 and details_of_citizens.Taluka = $talukaID
                    GROUP BY hospital_types.type_of_hospital, details_of_citizens.Village, details_of_citizens.Hospital_type"));
        }
        $Hospital_type = DB::table('hospital_types')
                    ->where('Active','1')
                    ->get();

        return view('Hospital_type_wise',compact('Hospital_type','Hospital_Type_Wise','district')); 
    }




   

    public function Taluka_Handicap_YN($DistrictID)
    {
        if($DistrictID > 0)
        {
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",$DistrictID)
                    ->get();
            
            $Handicap_YN = DB::select(
            DB::raw("SELECT talukas.taluka_name as Name, 
                            count( case when details_of_citizens.are_you_handicapped = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.are_you_handicapped = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative,
                            count( case when details_of_citizens.are_you_handicapped = '0'
                                        then 1 
                                        else Null
                                end
                                ) as BLANK
                        FROM `talukas`
                        Left join details_of_citizens on (talukas.id = details_of_citizens.Taluka)
                        where talukas.Active = 1 and talukas.district_id = $DistrictID
                        group by talukas.taluka_name"));
        }
        else
        {
            $district=  DB::table("districts")
                    ->select('districts.id as ID','districts.name_of_district as Name')
                    ->get();

            $Handicap_YN = DB::select(
            DB::raw("SELECT districts.name_of_district as Name, 
                            count( case when details_of_citizens.are_you_handicapped = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.are_you_handicapped = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative,
                            count( case when details_of_citizens.are_you_handicapped = '0'
                                        then 1 
                                        else Null
                                end
                                )as BLANK
                        FROM `districts`
                        Left join details_of_citizens on (districts.id = details_of_citizens.District)
                        where districts.Active = 1 
                        group by districts.name_of_district"));
        }
        return view('HanidcapYN',compact('Handicap_YN','district'));
    }

    public function Village_Handicap_YN($talukaID)
    {
        if($talukaID > 0)
        {
            $district = DB::table("villages")
                ->select('villages.name_of_village as Name','villages.id as ID','villages.District_id','villages.Taluka_id')
                ->where('Taluka_id',$talukaID)
                ->where('Active','1')
                ->get();
            
            $Handicap_YN = DB::select(
            DB::raw("SELECT villages.name_of_village as Name, 
                            count( case when details_of_citizens.are_you_handicapped = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.are_you_handicapped = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative,
                            count( case when details_of_citizens.are_you_handicapped = '0'
                                        then 1 
                                        else Null
                                end
                                ) as BLANK
                        FROM `villages`
                        Left join details_of_citizens on (villages.id = details_of_citizens.Village)
                        where villages.Active = 1 and villages.taluka_id = $talukaID
                        group by villages.name_of_village"));
        }
        return view('HanidcapYN',compact('Handicap_YN','district'));
    }






    

    public function Taluka_Handicap_wise($DistrictID)
    {
        if($DistrictID > 0)
        {
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",$DistrictID)
                    ->get();
               
            $Hancicap_wise = DB::select(
                        DB::raw("SELECT details_of_citizens.Taluka as District, Handicap_id ,count(citizen_handicaps.id) as total 
                        FROM `citizen_handicaps` 
                        INNER JOIN details_of_citizens ON (details_of_citizens.id = citizen_handicaps.Citizen_id) 
                        where details_of_citizens.District = $DistrictID
                        group By details_of_citizens.Taluka, Handicap_id"));
        }

        else
        {
            $district=  DB::table("districts")
                    ->select('districts.id as ID','districts.name_of_district as Name')
                    ->get();
            
            $Hancicap_wise = DB::select(
                    DB::raw("SELECT details_of_citizens.District, Handicap_id ,count(citizen_handicaps.id) as total 
                    FROM `citizen_handicaps` 
                    INNER JOIN details_of_citizens ON (details_of_citizens.id = citizen_handicaps.Citizen_id) 
                    group By details_of_citizens.District, Handicap_id"));
        }
        
        $handicap_types = DB::table('handicap_types')
                    ->where('Active','1')
                    ->get();

        return view('Handicap_type_wise',compact('handicap_types','Hancicap_wise','district'));
    }

    public function Village_Handicap_wise($talukaID)
    {
        if($talukaID > 0)
        {
            $district = DB::table("villages")
                ->select('villages.name_of_village as Name','villages.id as ID','villages.District_id','villages.Taluka_id')
                ->where('Taluka_id',$talukaID)
                ->where('Active','1')
                ->get();
            
            $Hancicap_wise = DB::select(
                        DB::raw("SELECT details_of_citizens.Village as District, Handicap_id ,count(citizen_handicaps.id) as total 
                        FROM `citizen_handicaps` 
                        INNER JOIN details_of_citizens ON (details_of_citizens.id = citizen_handicaps.Citizen_id) 
                        where details_of_citizens.Taluka = $talukaID
                        group By details_of_citizens.Village, Handicap_id"));
        }

        $handicap_types = DB::table('handicap_types')
            ->where('Active','1')
            ->get();

        return view('Handicap_type_wise',compact('handicap_types','Hancicap_wise','district'));
    }







    

    public function Taluka_Chores_wise($DistrictID)
    {
        if($DistrictID > 0)
        {
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",$DistrictID)
                    ->get();

            $Daily_Chores_wise = DB::table("details_of_citizens")                
                    ->RightJoin('talukas','talukas.id','=','details_of_citizens.Taluka')
                    ->select('talukas.taluka_name as Name','details_of_citizens.Taluka as District','details_of_citizens.daily_chores', DB::raw('count(details_of_citizens.Taluka) as total'))
                    ->where('talukas.district_id',$DistrictID)
                    ->groupBy('details_of_citizens.daily_chores','talukas.taluka_name','details_of_citizens.Taluka')
                    ->orderBy('taluka_name')
                    ->get();
        }
        else
        {
            $district=  DB::table("districts")
                    ->select('districts.id as ID','districts.name_of_district as Name')
                    ->get();

            $Daily_Chores_wise = DB::table("details_of_citizens")                
                ->RightJoin('districts','districts.id','=','details_of_citizens.District')
				->select('districts.name_of_district','details_of_citizens.District','details_of_citizens.daily_chores', DB::raw('count(*) as total'))
				->groupBy('details_of_citizens.daily_chores','districts.name_of_district','details_of_citizens.District')
                ->orderBy('name_of_district')
				->get();
        }

        $daily_chores = DB::table('help_types')
                    ->where('Active','1')
                    ->get();
            
        return view('Chores_Wise_dashboard',compact('daily_chores','Daily_Chores_wise','district'));
    }

    public function Village_Chores_wise($talukaID)
    {
        if($talukaID > 0)
        {
            $district = DB::table("villages")
                ->select('villages.name_of_village as Name','villages.id as ID','villages.District_id','villages.Taluka_id')
                ->where('Taluka_id',$talukaID)
                ->where('Active','1')
                ->get();

            $Daily_Chores_wise = DB::table("details_of_citizens")                
                    ->RightJoin('villages','villages.id','=','details_of_citizens.Village')
                    ->select('villages.name_of_village as Name','details_of_citizens.Village as District','details_of_citizens.daily_chores', DB::raw('count(details_of_citizens.Village) as total'))
                    ->where('villages.taluka_id',$talukaID)
                    ->groupBy('details_of_citizens.daily_chores','villages.name_of_village','details_of_citizens.Village')
                    ->orderBy('name_of_village')
                    ->get();
        }
        $daily_chores = DB::table('help_types')
                    ->where('Active','1')
                    ->get();
            
        return view('Chores_Wise_dashboard',compact('daily_chores','Daily_Chores_wise','district'));
    }

    






    

    public function Taluka_RationCardYN($DistrictID)
    {
        if($DistrictID > 0)
        {
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",$DistrictID)
                    ->get();
            
            $No_Ration_card = DB::select(
                    DB::raw("SELECT talukas.taluka_name as Name,
                        count( case when details_of_citizens.Ration_card = '1'
                                    then 1 
                            end
                            ) as Negative,
                        count( case when details_of_citizens.Ration_card != '1' and details_of_citizens.Ration_card != '0'
                                    then 1 
                            end
                            ) as YES,
                        count( case when details_of_citizens.Ration_card = '0'
                                    then 1 
                            end
                            )as BLANK
                    FROM `talukas`
                    Left join details_of_citizens on (talukas.id = details_of_citizens.Taluka)
                    where talukas.district_id = $DistrictID
                    group by talukas.taluka_name"));
            
            $count = DB::select(
                    DB::raw("select talukas.id as District_ID, count(details_of_citizens.Taluka) as totalCount
                    From talukas
                    Left JOIN details_of_citizens ON (details_of_citizens.Taluka = talukas.id) 
                    where talukas.District_id = $DistrictID
                    group By talukas.id, details_of_citizens.Taluka"));
        }
        else
        {
            $district=  DB::table("districts")
                    ->select('districts.id as ID','districts.name_of_district as Name')
                    ->get();
            
            $count = DB::select(
                    DB::raw("select districts.id as District_ID, count(details_of_citizens.District) as totalCount
                    From districts
                    left JOIN details_of_citizens ON (details_of_citizens.District = districts.id) 
                    group By districts.id, details_of_citizens.District"));

            $No_Ration_card = DB::select(
                        DB::raw("SELECT districts.name_of_district as Name,
                            count( case when details_of_citizens.Ration_card = '1'
                                        then 1 
                                end
                                ) as Negative,
                            count( case when details_of_citizens.Ration_card != '1' and details_of_citizens.Ration_card != '0'
                                        then 1 
                                end
                                ) as YES,
                            count( case when details_of_citizens.Ration_card = '0'
                                        then 1 
                                end
                                )as BLANK
                        FROM `districts`
                        Left join details_of_citizens on (districts.id = details_of_citizens.District)
                        group by districts.name_of_district"));

        }
        return view('Ration_Card_YN',compact('count','No_Ration_card','district'));
    }

    public function Village_RationCardYN($talukaID)
    {
        if($talukaID>0)
        {
            $district = DB::table("villages")
                ->select('villages.name_of_village as Name','villages.id as ID','villages.District_id','villages.Taluka_id')
                ->where('Taluka_id',$talukaID)
                ->where('Active','1')
                ->get();

            $No_Ration_card = DB::select(
                    DB::raw("SELECT villages.name_of_village as Name,
                            count( case when details_of_citizens.Ration_card = '1'
                                        then 1 
                                end
                                ) as Negative,
                            count( case when details_of_citizens.Ration_card != '1' and details_of_citizens.Ration_card != '0'
                                        then 1 
                                end
                                ) as YES,
                            count( case when details_of_citizens.Ration_card = '0'
                                        then 1 
                                end
                                )as BLANK
                        FROM `villages`
                        Left join details_of_citizens on (villages.id = details_of_citizens.Village)
                        where villages.Taluka_id = $talukaID
                        group by villages.name_of_village"));
            
            $count = DB::select(
                    DB::raw("select villages.id as District_ID, count(details_of_citizens.Village) as totalCount
                    From villages
                    Left JOIN details_of_citizens ON (details_of_citizens.Village = villages.id) 
                    where villages.Taluka_id = $talukaID
                    group By villages.id, details_of_citizens.Village"));
        }
        return view('Ration_Card_YN',compact('count','No_Ration_card','district'));
    }






    

    public function Taluka_RationCard_Type_Wise($DistrictID)
    {
        if($DistrictID > 0)
        {
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",$DistrictID)
                    ->get();

            $RationCard_wise =  DB::select(
                    DB::raw("SELECT ration_card_types.type_of_ration_card, details_of_citizens.Taluka as District, details_of_citizens.Ration_card, count(*) as total 
                    FROM details_of_citizens 
                    INNER JOIN ration_card_types ON (ration_card_types.id = details_of_citizens.Ration_card) 
                    WHERE Active = 1 and details_of_citizens.District = $DistrictID
                    GROUP BY details_of_citizens.Taluka, ration_card_types.type_of_ration_card, details_of_citizens.Ration_card"));
        }
        else
        {
            $district=  DB::table("districts")
                    ->select('districts.id as ID','districts.name_of_district as Name')
                    ->get();
            
            $RationCard_wise =  DB::select(
                    DB::raw("SELECT ration_card_types.type_of_ration_card, details_of_citizens.District, details_of_citizens.Ration_card, count(*) as total 
                    FROM details_of_citizens 
                    INNER JOIN ration_card_types ON (ration_card_types.id = details_of_citizens.Ration_card) 
                    WHERE Active = 1 
                    GROUP BY details_of_citizens.District, ration_card_types.type_of_ration_card, details_of_citizens.Ration_card"));
        }
        $rationCard = DB::table('ration_card_types')
                    ->where('Active','1')
                    ->get();
        return view('RationCard_Type_Wise_Dashboard',compact('rationCard','RationCard_wise','district'));
    }

    public function Village_RationCard_Type_Wise($talukaID)
    {
        if($talukaID)
        {
            $district = DB::table("villages")
                ->select('villages.name_of_village as Name','villages.id as ID','villages.District_id','villages.Taluka_id')
                ->where('Taluka_id',$talukaID)
                ->where('Active','1')
                ->get();
        
            $RationCard_wise =  DB::select(
                    DB::raw("SELECT ration_card_types.type_of_ration_card, details_of_citizens.Village as District, details_of_citizens.Ration_card, count(*) as total 
                    FROM details_of_citizens 
                    INNER JOIN ration_card_types ON (ration_card_types.id = details_of_citizens.Ration_card) 
                    WHERE Active = 1 and details_of_citizens.Taluka = $talukaID
                    GROUP BY details_of_citizens.Village, ration_card_types.type_of_ration_card, details_of_citizens.Ration_card"));
        }
        $rationCard = DB::table('ration_card_types')
                    ->where('Active','1')
                    ->get();
        return view('RationCard_Type_Wise_Dashboard',compact('rationCard','RationCard_wise','district'));
    }




    

    public function Taluka_AadharWise($DistrictID)
    {
        if($DistrictID > 0)
        {
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",$DistrictID)
                    ->get();
            
            $AadharWise =  DB::select(
            DB::raw("SELECT talukas.taluka_name as Name, 
                            count( case when details_of_citizens.aadhar_card = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.aadhar_card = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative,
                            count( case when details_of_citizens.aadhar_card = '0'
                                        then 1 
                                        else Null
                                end
                                ) as BLANK
                        FROM `talukas`
                        Left join details_of_citizens on (talukas.id = details_of_citizens.Taluka)
                        where talukas.Active = 1 and talukas.district_id = $DistrictID
                        group by talukas.taluka_name"));
        }
        else
        {
            $district=  DB::table("districts")
                    ->select('districts.id as ID','districts.name_of_district as Name')
                    ->get();
            
            $AadharWise = DB::select(
            DB::raw("SELECT districts.name_of_district as Name, 
                            count( case when details_of_citizens.aadhar_card = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.aadhar_card = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative,
                            count( case when details_of_citizens.aadhar_card = '0'
                                        then 1 
                                        else Null
                                end
                                )as BLANK
                        FROM `districts`
                        Left join details_of_citizens on (districts.id = details_of_citizens.District)
                        where districts.Active = 1 
                        group by districts.name_of_district"));
        }
        return view('AadharWise',compact('AadharWise','district'));
    }

    public function Village_AadharWise($talukaID)
    {
        if($talukaID > 0)
        {
            $district = DB::table("villages")
                ->select('villages.name_of_village as Name','villages.id as ID','villages.District_id','villages.Taluka_id')
                ->where('Taluka_id',$talukaID)
                ->where('Active','1')
                ->get();

            $AadharWise =  DB::select(
            DB::raw("SELECT villages.name_of_village as Name, 
                            count( case when details_of_citizens.aadhar_card = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.aadhar_card = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative,
                            count( case when details_of_citizens.aadhar_card = '0'
                                        then 1 
                                        else Null
                                end
                                ) as BLANK
                        FROM `villages`
                        Left join details_of_citizens on (villages.id = details_of_citizens.Village)
                        where villages.Active = 1 and villages.taluka_id = $talukaID
                        group by villages.name_of_village"));
        }
        return view('AadharWise',compact('AadharWise','district'));
    }






    

    public function Taluka_AadharDiscrepancy($DistrictID)
    {
        if($DistrictID > 0)
        {
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",$DistrictID)
                    ->where('Active','1')
                    ->get();
            
            $AadharDiscrepancyWise = DB::select(
            DB::raw("SELECT talukas.taluka_name as Name, 
                            count( case when details_of_citizens.aadhar_discrepancy = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.aadhar_discrepancy = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative,
                            count( case when details_of_citizens.aadhar_discrepancy = '0'
                                        then 1 
                                        else Null
                                end
                                ) as BLANK
                        FROM `talukas`
                        Left join details_of_citizens on (talukas.id = details_of_citizens.Taluka)
                        where talukas.Active = 1 and talukas.district_id = $DistrictID
                        group by talukas.taluka_name"));
        }
        else
        {
            $district=  DB::table("districts")
                    ->select('districts.id as ID','districts.name_of_district as Name')
                    ->where('districts.Active','1')
                    ->get();
            
            $AadharDiscrepancyWise = DB::select(
            DB::raw("SELECT districts.name_of_district as Name, 
                            count( case when details_of_citizens.aadhar_discrepancy = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.aadhar_discrepancy = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative,
                            count( case when details_of_citizens.aadhar_discrepancy = '0'
                                        then 1 
                                        else Null
                                end
                                )as BLANK
                        FROM `districts`
                        Left join details_of_citizens on (districts.id = details_of_citizens.District)
                        where districts.Active = 1 and details_of_citizens.aadhar_card = 'Y'
                        group by districts.name_of_district"));
        }
        return view('Aadhar_Discrepancy_Wise',compact('AadharDiscrepancyWise','district'));
    }

    public function Village_AadharDiscrepancy($talukaID)
    {
        if($talukaID > 0)
        {
            $district = DB::table("villages")
                ->select('villages.name_of_village as Name','villages.id as ID','villages.District_id','villages.Taluka_id')
                ->where('Taluka_id',$talukaID)
                ->where('Active','1')
                ->get();

            $AadharDiscrepancyWise = DB::select(
            DB::raw("SELECT villages.name_of_village as Name, 
                            count( case when details_of_citizens.aadhar_discrepancy = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.aadhar_discrepancy = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative,
                            count( case when details_of_citizens.aadhar_discrepancy = '0'
                                        then 1 
                                        else Null
                                end
                                ) as BLANK
                        FROM `villages`
                        Left join details_of_citizens on (villages.id = details_of_citizens.Village)
                        where villages.Active = 1 and villages.taluka_id = $talukaID
                        group by villages.name_of_village"));
        }
        return view('Aadhar_Discrepancy_Wise',compact('AadharDiscrepancyWise','district'));
    }







    

    public function Taluka_VoterID($DistrictID)
    {
        if($DistrictID > 0)
        {
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",$DistrictID)
                    ->get();

            $VoterIdWise = DB::select(
            DB::raw("SELECT talukas.taluka_name as Name, 
                            count( case when details_of_citizens.Voter_id = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.Voter_id = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative,
                            count( case when details_of_citizens.Voter_id = '0'
                                        then 1 
                                        else Null
                                end
                                ) as BLANK
                        FROM `talukas`
                        Left join details_of_citizens on (talukas.id = details_of_citizens.Taluka)
                        where talukas.Active = 1 and talukas.district_id = $DistrictID
                        group by talukas.taluka_name"));
        }
        else
        {
            $district=  DB::table("districts")
                    ->select('districts.id as ID','districts.name_of_district as Name')
                    ->get();

            $VoterIdWise = DB::select(
            DB::raw("SELECT districts.name_of_district as Name, 
                            count( case when details_of_citizens.Voter_id = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.Voter_id = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative,
                            count( case when details_of_citizens.Voter_id = '0'
                                        then 1 
                                        else Null
                                end
                                )as BLANK
                        FROM `districts`
                        Left join details_of_citizens on (districts.id = details_of_citizens.District)
                        where districts.Active = 1 
                        group by districts.name_of_district"));
        }
        return view('Voter_ID_Wise',compact('VoterIdWise','district'));
    }

    public function Village_VoterID($talukaID)
    {
        if($talukaID > 0)
        {
            $district = DB::table("villages")
                ->select('villages.name_of_village as Name','villages.id as ID','villages.District_id','villages.Taluka_id')
                ->where('Taluka_id',$talukaID)
                ->where('Active','1')
                ->get();

            $VoterIdWise = DB::select(
            DB::raw("SELECT villages.name_of_village as Name, 
                            count( case when details_of_citizens.Voter_id = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.Voter_id = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative,
                            count( case when details_of_citizens.Voter_id = '0'
                                        then 1 
                                        else Null
                                end
                                ) as BLANK
                        FROM `villages`
                        Left join details_of_citizens on (villages.id = details_of_citizens.Village)
                        where villages.Active = 1 and villages.taluka_id = $talukaID
                        group by villages.name_of_village"));        
        }
        return view('Voter_ID_Wise',compact('VoterIdWise','district'));
    }








    

    public function Taluka_STPass($DistrictID)
    {
        if($DistrictID > 0)
        {
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",$DistrictID)
                    ->get();

            $STPassWise = DB::select(
                        DB::raw("SELECT talukas.taluka_name as Name, 
                            count( case when details_of_citizens.ST_pass = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.ST_pass = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative,
                            count( case when details_of_citizens.ST_pass = '0'
                                        then 1 
                                        else Null
                                end
                                )as BLANK
                        FROM `talukas`
                        Left join details_of_citizens on (talukas.id = details_of_citizens.Taluka)
                        where talukas.Active = 1 and talukas.district_id = $DistrictID
                        group by talukas.taluka_name"));
        }
        else
        {
            $district=  DB::table("districts")
                    ->select('districts.id as ID','districts.name_of_district as Name')
                    ->get();
            
            $STPassWise = DB::select(
                        DB::raw("SELECT districts.name_of_district as Name, 
                            count( case when details_of_citizens.ST_pass = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.ST_pass = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative,
                            count( case when details_of_citizens.ST_pass = '0'
                                        then 1 
                                        else Null
                                end
                                )as BLANK
                        FROM `districts`
                        Left join details_of_citizens on (districts.id = details_of_citizens.District)
                        where districts.Active = 1 
                        group by districts.name_of_district"));
        }
        return view('STPass_Wise',compact('STPassWise','district'));
    }

    public function Village_STPass($talukaID)
    {
        if($talukaID > 0)
        {
            $district = DB::table("villages")
                ->select('villages.name_of_village as Name','villages.id as ID','villages.District_id','villages.Taluka_id')
                ->where('Taluka_id',$talukaID)
                ->where('Active','1')
                ->get();

            $STPassWise = DB::select(
                        DB::raw("SELECT villages.name_of_village as Name, 
                            count( case when details_of_citizens.ST_pass = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.ST_pass = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative,
                            count( case when details_of_citizens.ST_pass = '0'
                                        then 1 
                                        else Null
                                end
                                )as BLANK
                        FROM `villages`
                        Left join details_of_citizens on (villages.id = details_of_citizens.Village)
                        where villages.Active = 1 and villages.taluka_id = $talukaID
                        group by villages.name_of_village"));
        }
        return view('STPass_Wise',compact('STPassWise','district'));
    }




    
    public function Taluka_SchemeYN($DistrictID)
    {
        if($DistrictID > 0)
        {
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",$DistrictID)
                    ->get();

            $SchemeAvail = DB::select(
            DB::raw("SELECT talukas.taluka_name as Name, 
                            count( case when details_of_citizens.Govt_schemes = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.Govt_schemes = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative,
                            count( case when details_of_citizens.Govt_schemes = '0'
                                        then 1 
                                        else Null
                                end
                                )as BLANK
                        FROM `talukas`
                        Left join details_of_citizens on (talukas.id = details_of_citizens.Taluka)
                        where talukas.Active = 1 and talukas.district_id = $DistrictID
                        group by talukas.taluka_name"));
        }
        else
        {
            $district=  DB::table("districts")
                    ->select('districts.id as ID','districts.name_of_district as Name')
                    ->get();

            $SchemeAvail =DB::select(
            DB::raw("SELECT districts.name_of_district as Name, 
                            count( case when details_of_citizens.Govt_schemes = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.Govt_schemes = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative,
                            count( case when details_of_citizens.Govt_schemes = '0'
                                        then 1 
                                        else Null
                                end
                                )as BLANK
                        FROM `districts`
                        Left join details_of_citizens on (districts.id = details_of_citizens.District)
                        where districts.Active = 1 
                        group by districts.name_of_district"));
        }
        return view('SchemeYN',compact('SchemeAvail','district'));
    }

    public function Village_SchemeYN($talukaID)
    {
        if($talukaID > 0)
        {
            $district = DB::table("villages")
                ->select('villages.name_of_village as Name','villages.id as ID','villages.District_id','villages.Taluka_id')
                ->where('Taluka_id',$talukaID)
                ->where('Active','1')
                ->get();

            $SchemeAvail = DB::select(
            DB::raw("SELECT villages.name_of_village as Name, 
                            count( case when details_of_citizens.Govt_schemes = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.Govt_schemes = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative,
                            count( case when details_of_citizens.Govt_schemes = '0'
                                        then 1 
                                        else Null
                                end
                                )as BLANK
                        FROM `villages`
                        Left join details_of_citizens on (villages.id = details_of_citizens.Village)
                        where villages.Active = 1 and villages.Taluka_id = $talukaID
                        group by villages.name_of_village"));
        }
        return view('SchemeYN',compact('SchemeAvail','district'));
    }



    

    public function Taluka_Govt_Scheme_Wise($DistrictID)
    {
        if($DistrictID > 0)
        {
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",$DistrictID)
                    ->get();

            $SchemeWise = DB::select(
                    DB::raw("SELECT details_of_citizens.Taluka as District, Govt_scheme_id,count(citizen_govt_schemes.id) as total
                    FROM `citizen_govt_schemes` 
                    INNER JOIN details_of_citizens ON (details_of_citizens.id = citizen_govt_schemes.Citizen_id) 
                    where details_of_citizens.District = $DistrictID
                    group By details_of_citizens.Taluka, Govt_scheme_id"));
        }
        else
        {
            $district=  DB::table("districts")
                    ->select('districts.id as ID','districts.name_of_district as Name')
                    ->get();
            
            $SchemeWise = DB::select(
                    DB::raw("SELECT details_of_citizens.District, Govt_scheme_id,count(citizen_govt_schemes.id) as total
                    FROM `citizen_govt_schemes` 
                    INNER JOIN details_of_citizens ON (details_of_citizens.id = citizen_govt_schemes.Citizen_id) 
                    group By details_of_citizens.District, Govt_scheme_id"));
        }
        $schemes = DB::table("govt_scheme_types")
                ->where('Active','1')
                ->get();

        return view('Scheme_wise',compact('schemes','SchemeWise','district'));
    }

    public function village_Govt_Scheme_Wise($talukaID)
    {
        if($talukaID > 0)
        {
            $district = DB::table("villages")
                ->select('villages.name_of_village as Name','villages.id as ID','villages.District_id','villages.Taluka_id')
                ->where('Taluka_id',$talukaID)
                ->where('Active','1')
                ->get();
            
            $SchemeWise = DB::select(
                    DB::raw("SELECT details_of_citizens.Village as District, Govt_scheme_id,count(citizen_govt_schemes.id) as total
                    FROM `citizen_govt_schemes` 
                    INNER JOIN details_of_citizens ON (details_of_citizens.id = citizen_govt_schemes.Citizen_id) 
                    where details_of_citizens.Taluka = $talukaID
                    group By details_of_citizens.Village, Govt_scheme_id"));
        }
        $schemes = DB::table("govt_scheme_types")
                ->where('Active','1')
                ->get();

        return view('Scheme_wise',compact('schemes','SchemeWise','district'));
    }






    

    public function Taluka_Income_Increase_YN($DistrictID)
    {
        if($DistrictID > 0)
        {
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",$DistrictID)
                    ->get();

            $income_increase_YN = DB::select(
                    DB::raw("SELECT talukas.taluka_name as Name, 
                            count( case when details_of_citizens.income_increase = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.income_increase = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative,
                            count( case when details_of_citizens.income_increase = '0'
                                        then 1 
                                        else Null
                                end
                                )as BLANK
                        FROM `talukas`
                        Left join details_of_citizens on (talukas.id = details_of_citizens.Taluka)
                        where talukas.district_id = $DistrictID and talukas.Active = 1
                        group by talukas.taluka_name"));   
        }
        else
        {
            $district=  DB::table("districts")
                    ->select('districts.id as ID','districts.name_of_district as Name')
                    ->get();

            $income_increase_YN = DB::select(
                    DB::raw("SELECT districts.name_of_district as Name, 
                            count( case when details_of_citizens.income_increase = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.income_increase = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative,
                            count( case when details_of_citizens.income_increase = '0'
                                        then 1 
                                        else Null
                                end
                                )as BLANK
                        FROM `districts`
                        Left join details_of_citizens on (districts.id = details_of_citizens.District)
                        where districts.Active = 1
                        group by districts.name_of_district"));
        }
        return view('Income_increase_YN',compact('income_increase_YN','district')); 
    }

    public function Village_Income_Increase_YN($talukaID)
    {  
        if($talukaID > 0)
        {
            $district = DB::table("villages")
                ->select('villages.name_of_village as Name','villages.id as ID','villages.District_id','villages.Taluka_id')
                ->where('Taluka_id',$talukaID)
                ->where('Active','1')
                ->get();

            $income_increase_YN = DB::select(
                    DB::raw("SELECT villages.name_of_village as Name, 
                            count( case when details_of_citizens.income_increase = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.income_increase = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative,
                            count( case when details_of_citizens.income_increase = '0'
                                        then 1 
                                        else Null
                                end
                                )as BLANK
                        FROM `villages`
                        Left join details_of_citizens on (villages.id = details_of_citizens.Village)
                        where villages.Active = 1 and villages.taluka_id = $talukaID
                        group by villages.name_of_village"));      
        }
        return view('Income_increase_YN',compact('income_increase_YN','district')); 
    }







    

    public function Taluka_Income_Increase_Wise($DistrictID)
    {
        if($DistrictID > 0)
        {
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",$DistrictID)
                    ->get(); 

            $Work_type_wise = DB::select(
                        DB::raw("SELECT details_of_citizens.Taluka as District, Work_type_id ,count(citizen_work_types.id) as total
                            FROM `citizen_work_types` 
                            INNER JOIN details_of_citizens ON (details_of_citizens.id = citizen_work_types.Citizen_id) 
                            where details_of_citizens.District = $DistrictID
                            group By details_of_citizens.Taluka, Work_type_id"));
        }
        else
        {
            $district=  DB::table("districts")
                    ->select('districts.id as ID','districts.name_of_district as Name')
                    ->get();

            $Work_type_wise = DB::select(
                    DB::raw("SELECT details_of_citizens.District, Work_type_id ,count(citizen_work_types.id) as total
                        FROM `citizen_work_types` 
                        INNER JOIN details_of_citizens ON (details_of_citizens.id = citizen_work_types.Citizen_id) 
                        group By details_of_citizens.District, Work_type_id"));      
        }
        $income_increase = DB::table("work_types")
                        ->where("Active","1")
                        ->get();
        return view('Income_Increase_wise',compact('income_increase','Work_type_wise','district'));       
    }

    public function Village_Income_Increase_Wise($talukaID)
    {
        if($talukaID > 0)
        {
            $district = DB::table("villages")
                ->select('villages.name_of_village as Name','villages.id as ID','villages.District_id','villages.Taluka_id')
                ->where('Taluka_id',$talukaID)
                ->where('Active','1')
                ->get();

            $Work_type_wise = DB::select(
                        DB::raw("SELECT details_of_citizens.Village as District, Work_type_id ,count(citizen_work_types.id) as total
                            FROM `citizen_work_types` 
                            INNER JOIN details_of_citizens ON (details_of_citizens.id = citizen_work_types.Citizen_id) 
                            where details_of_citizens.Taluka = $talukaID
                            group By details_of_citizens.Village, Work_type_id"));
        }
        $income_increase = DB::table("work_types")
                        ->where("Active","1")
                        ->get();
        return view('Income_Increase_wise',compact('income_increase','Work_type_wise','district'));
    }











    

    public function Taluka_Tool_YN($DistrictID)
    {
        if($DistrictID > 0)
        {
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",$DistrictID)
                    ->get();

            $Tools_YN = DB::select(
                        DB::raw("SELECT talukas.taluka_name as Name, 
                            count( case when details_of_citizens.tools_required = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.tools_required = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative,
                            count( case when details_of_citizens.tools_required = '0'
                                        then 1 
                                        else Null
                                end
                                )as BLANK
                        FROM `talukas`
                        Left join details_of_citizens on (talukas.id = details_of_citizens.Taluka)
                        where talukas.Active = 1 and talukas.district_id = $DistrictID
                        group by talukas.taluka_name"));
        }
        else
        {
            $district=  DB::table("districts")
                    ->select('districts.id as ID','districts.name_of_district as Name')
                    ->get();

            $Tools_YN = DB::select(
                        DB::raw("SELECT districts.name_of_district as Name, 
                            count( case when details_of_citizens.tools_required = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.tools_required = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative,
                            count( case when details_of_citizens.tools_required = '0'
                                        then 1 
                                        else Null
                                end
                                )as BLANK
                        FROM `districts`
                        Left join details_of_citizens on (districts.id = details_of_citizens.District)
                        where districts.Active = 1
                        group by districts.name_of_district"));     
        }
        $tools = DB::table("tool_types")
                        ->where("Active","1")
                        ->get();
        return view('Tools_YN',compact('Tools_YN','district'));   
    }

    public function Village_Tool_YN($talukaID)
    {
        if($talukaID > 0)
        {
            $district = DB::table("villages")
                ->select('villages.name_of_village as Name','villages.id as ID','villages.District_id','villages.Taluka_id')
                ->where('Taluka_id',$talukaID)
                ->where('Active','1')
                ->get();
            
            $Tools_YN = DB::select(
                        DB::raw("SELECT villages.name_of_village as Name, 
                            count( case when details_of_citizens.tools_required = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.tools_required = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative,
                            count( case when details_of_citizens.tools_required = '0'
                                        then 1 
                                        else Null
                                end
                                )as BLANK
                        FROM `villages`
                        Left join details_of_citizens on (villages.id = details_of_citizens.Village)
                        where villages.Active = 1 and villages.taluka_id = $talukaID
                        group by villages.name_of_village"));
        }
        $tools = DB::table("tool_types")
                        ->where("Active","1")
                        ->get();
        return view('Tools_YN',compact('Tools_YN','district')); 
    }




    

    public function Taluka_Tool_wise($DistrictID)
    {
        if($DistrictID > 0)
        {
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",$DistrictID)
                    ->get();
            
            $Tool_wise = DB::select(
                DB::raw("SELECT details_of_citizens.Taluka as District, Tool_type_id ,count(citizen_tools.id) as total 
                FROM `citizen_tools` 
                INNER JOIN details_of_citizens ON (details_of_citizens.id = citizen_tools.Citizen_id) 
                where details_of_citizens.District = $DistrictID
                group By details_of_citizens.Taluka, Tool_type_id"));
        }
        else
        {
            $district=  DB::table("districts")
                    ->select('districts.id as ID','districts.name_of_district as Name')
                    ->get();
            
            $Tool_wise = DB::select(
                DB::raw("SELECT details_of_citizens.District, Tool_type_id ,count(citizen_tools.id) as total 
                FROM `citizen_tools` 
                INNER JOIN details_of_citizens ON (details_of_citizens.id = citizen_tools.Citizen_id) 
                group By details_of_citizens.District, Tool_type_id"));
        }
        $tools = DB::table("tool_types")
                        ->where("Active","1")
                        ->get();
        return view('Tool_wise',compact('tools','Tool_wise','district')); 
    }

    public function Village_Tool_wise($talukaID)
    {
        if($talukaID > 0)
        {
            $district = DB::table("villages")
                ->select('villages.name_of_village as Name','villages.id as ID','villages.District_id','villages.Taluka_id')
                ->where('Taluka_id',$talukaID)
                ->where('Active','1')
                ->get();
            
            $Tool_wise = DB::select(
                DB::raw("SELECT details_of_citizens.Village as District, Tool_type_id ,count(citizen_tools.id) as total 
                FROM `citizen_tools` 
                INNER JOIN details_of_citizens ON (details_of_citizens.id = citizen_tools.Citizen_id) 
                where details_of_citizens.Taluka = $talukaID
                group By details_of_citizens.Village, Tool_type_id"));
        }
        $tools = DB::table("tool_types")
                        ->where("Active","1")
                        ->get();
        return view('Tool_wise',compact('tools','Tool_wise','district')); 
    }








    

    public function Taluka_medical_equipment($DistrictID)
    {
        if($DistrictID > 0)
        {
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",$DistrictID)
                    ->get();

            $Medical_equipment_wise = DB::select(
                        DB::raw("SELECT details_of_citizens.Taluka as District, medical_equipment_id ,count(citizen_medical_equipments.id) as total 
                        FROM `citizen_medical_equipments` 
                        INNER JOIN details_of_citizens ON (details_of_citizens.id = citizen_medical_equipments.Citizen_id) 
                        where details_of_citizens.District = $DistrictID
                        group By details_of_citizens.Taluka, medical_equipment_id"));
        }
        else
        {
            $district=  DB::table("districts")
                    ->select('districts.id as ID','districts.name_of_district as Name')
                    ->get();

            $Medical_equipment_wise = DB::select(
                        DB::raw("SELECT details_of_citizens.District, medical_equipment_id ,count(citizen_medical_equipments.id) as total 
                        FROM `citizen_medical_equipments` 
                        INNER JOIN details_of_citizens ON (details_of_citizens.id = citizen_medical_equipments.Citizen_id) 
                        group By details_of_citizens.District, medical_equipment_id"));
        }
        $mediacl_instruments = DB::table("medical_equipment_types")
                        ->where("Active","1")
                        ->get();
        return view('Medical_equipment_wise',compact('mediacl_instruments','Medical_equipment_wise','district'));       
    }

    public function Village_medical_equipment($talukaID)
    {
        if($talukaID > 0)
        {
            $district = DB::table("villages")
                ->select('villages.name_of_village as Name','villages.id as ID','villages.District_id','villages.Taluka_id')
                ->where('Taluka_id',$talukaID)
                ->where('Active','1')
                ->get();
            
            $Medical_equipment_wise = DB::select(
                        DB::raw("SELECT details_of_citizens.Village as District, medical_equipment_id ,count(citizen_medical_equipments.id) as total 
                        FROM `citizen_medical_equipments` 
                        INNER JOIN details_of_citizens ON (details_of_citizens.id = citizen_medical_equipments.Citizen_id) 
                        where details_of_citizens.Taluka = $talukaID
                        group By details_of_citizens.Village, medical_equipment_id"));
        }
        $mediacl_instruments = DB::table("medical_equipment_types")
                        ->where("Active","1")
                        ->get();
        return view('Medical_equipment_wise',compact('mediacl_instruments','Medical_equipment_wise','district'));  
    }





    

    public function Taluka_Social_service_YN($DistrictID)
    {
        if($DistrictID)
        {
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",$DistrictID)
                    ->get();

            $Social_service_YN = DB::select(
                DB::raw("SELECT talukas.taluka_name as Name, 
                            count( case when details_of_citizens.social_service = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.social_service = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative,
                            count( case when details_of_citizens.social_service = '0'
                                        then 1 
                                        else Null
                                end
                                )as BLANK
                        FROM `talukas`
                        Left join details_of_citizens on (talukas.id = details_of_citizens.Taluka)
                        where talukas.Active = 1 and talukas.district_id = $DistrictID
                        group by talukas.taluka_name"));
        }
        else
        {
            $district=  DB::table("districts")
                    ->select('districts.id as ID','districts.name_of_district as Name')
                    ->get();

            $Social_service_YN = DB::select(
                DB::raw("SELECT districts.name_of_district as Name, 
                            count( case when details_of_citizens.social_service = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.social_service = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative,
                            count( case when details_of_citizens.social_service = '0'
                                        then 1 
                                        else Null
                                end
                                )as BLANK
                        FROM `districts`
                        Left join details_of_citizens on (districts.id = details_of_citizens.District)
                        where districts.Active = 1 
                        group by districts.name_of_district"));
        }
        return view('Social_service_YN',compact('Social_service_YN','district'));
    }

    public function Village_Social_service_YN($talukaID)
    {
        if($talukaID > 0)
        {
            $district = DB::table("villages")
                ->select('villages.name_of_village as Name','villages.id as ID','villages.District_id','villages.Taluka_id')
                ->where('Taluka_id',$talukaID)
                ->where('Active','1')
                ->get();

            $Social_service_YN = DB::select(
                DB::raw("SELECT villages.name_of_village as Name, 
                            count( case when details_of_citizens.social_service = 'Y'
                                        then 1 
                                        else Null
                                end
                                ) as YES,
                            count( case when details_of_citizens.social_service = 'N'
                                        then 1 
                                        else Null
                                end
                                ) as Negative,
                            count( case when details_of_citizens.social_service = '0'
                                        then 1 
                                        else Null
                                end
                                )as BLANK
                        FROM `villages`
                        Left join details_of_citizens on (villages.id = details_of_citizens.Village)
                        where villages.Active = 1 and villages.taluka_id = $talukaID
                        group by villages.name_of_village"));
        }
        return view('Social_service_YN',compact('Social_service_YN','district'));
    }




    

    public function Taluka_Social_service_wise($DistrictID)
    {
        if($DistrictID > 0)
        {
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",$DistrictID)
                    ->get();

            $social_service_wise = DB::select(
                DB::raw("SELECT details_of_citizens.Taluka as District, social_service_id ,count(citizen_social_services.id) as total 
                FROM `citizen_social_services` 
                INNER JOIN details_of_citizens ON (details_of_citizens.id = citizen_social_services.Citizen_id) 
                where details_of_citizens.District = $DistrictID
                group By details_of_citizens.Taluka, social_service_id"));
        }
        else
        {
            $district=  DB::table("districts")
                    ->select('districts.id as ID','districts.name_of_district as Name')
                    ->get();

            $social_service_wise = DB::select(
                DB::raw("SELECT details_of_citizens.District, social_service_id ,count(citizen_social_services.id) as total 
                FROM `citizen_social_services` 
                INNER JOIN details_of_citizens ON (details_of_citizens.id = citizen_social_services.Citizen_id) 
                group By details_of_citizens.District, social_service_id"));
        }
        $social_service = DB::table("social_service_types")
                        ->where("Active","1")
                        ->get();
        return view('Social_service_wise',compact('social_service','social_service_wise','district'));  
    }

    public function Village_Social_service_wise($talukaID)
    {
        if($talukaID > 0)
        {
            $district = DB::table("villages")
                ->select('villages.name_of_village as Name','villages.id as ID','villages.District_id','villages.Taluka_id')
                ->where('Taluka_id',$talukaID)
                ->where('Active','1')
                ->get();
            
            $social_service_wise = DB::select(
                DB::raw("SELECT details_of_citizens.Village as District, social_service_id ,count(citizen_social_services.id) as total 
                FROM `citizen_social_services` 
                INNER JOIN details_of_citizens ON (details_of_citizens.id = citizen_social_services.Citizen_id) 
                where details_of_citizens.Taluka = $talukaID
                group By details_of_citizens.Village, social_service_id"));
        }
        $social_service = DB::table("social_service_types")
                        ->where("Active","1")
                        ->get();
        return view('Social_service_wise',compact('social_service','social_service_wise','district')); 
    }





    

    public function Taluka_Teaching_skill_Wise($DistrictID)
    {
        if($DistrictID > 0)
        {
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",$DistrictID)
                    ->get();
        
            $Teaching_skill_wise = DB::select(
                        DB::raw("SELECT details_of_citizens.Taluka as District, teaching_skill_id ,count(citizen_teaching_skills.id) as total 
                        FROM `citizen_teaching_skills` 
                        INNER JOIN details_of_citizens ON (details_of_citizens.id = citizen_teaching_skills.Citizen_id) 
                        where details_of_citizens.District = $DistrictID
                        group By details_of_citizens.Taluka, teaching_skill_id"));
        }
        else
        {
            $district=  DB::table("districts")
                    ->select('districts.id as ID','districts.name_of_district as Name')
                    ->get();

            $Teaching_skill_wise = DB::select(
                        DB::raw("SELECT details_of_citizens.District, teaching_skill_id ,count(citizen_teaching_skills.id) as total 
                        FROM `citizen_teaching_skills` 
                        INNER JOIN details_of_citizens ON (details_of_citizens.id = citizen_teaching_skills.Citizen_id) 
                        group By details_of_citizens.District, teaching_skill_id"));
        }
        $teaching_skills = DB::table("teaching_skills")
                        ->where("Active","1")
                        ->get();
        return view('Teaching_skill_wise',compact('teaching_skills','Teaching_skill_wise','district'));
    }

    public function village_Teaching_skill_Wise($talukaID)
    {
        if($talukaID > 0)
        {
            $district = DB::table("villages")
                ->select('villages.name_of_village as Name','villages.id as ID','villages.District_id','villages.Taluka_id')
                ->where('Taluka_id',$talukaID)
                ->where('Active','1')
                ->get();
            
            $Teaching_skill_wise = DB::select(
                        DB::raw("SELECT details_of_citizens.Village as District, teaching_skill_id ,count(citizen_teaching_skills.id) as total 
                        FROM `citizen_teaching_skills` 
                        INNER JOIN details_of_citizens ON (details_of_citizens.id = citizen_teaching_skills.Citizen_id) 
                        where details_of_citizens.Taluka = $talukaID
                        group By details_of_citizens.Village, teaching_skill_id"));
        }
        $teaching_skills = DB::table("teaching_skills")
                        ->where("Active","1")
                        ->get();
        return view('Teaching_skill_wise',compact('teaching_skills','Teaching_skill_wise','district'));
    }








    public function Hobby_wise()
    {
        if(Auth::user()->district_id != '')
        {
            $district= DB::table("districts")
                ->where("id",Auth::user()->district_id)
                ->get();    
        }
        else
        {
            $district=  DB::table("districts")
                    ->select('districts.id as ID','districts.name_of_district as Name')
                    ->get();
        }
        if(Auth::user()->district_id != '')
        {   
            $district = DB::table("talukas")
                ->where("district_id",Auth::user()->district_id)
                ->get();    
        }
        else
        {
            $taluka = '';
        }
        if( Auth::user()->district_id == '')
        {
            $district=  DB::table("districts")
                    ->select('districts.id as ID','districts.name_of_district as Name')
                    ->get();
        }
        elseif(Auth::user()->taluka_id == '')
        {
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",Auth::user()->district_id)
                    ->get();
        }
        else
        {
            $district = DB::table("villages")
                ->select('villages.name_of_village as Name','villages.id as ID','villages.District_id','villages.Taluka_id')
                ->where('Taluka_id',Auth::user()->taluka_id)
                ->where('Active','1')
                ->get();
        }

        $Hobbies = DB::table("hobbies")
                        ->where("Active","1")
                        ->get();

        $Hobby_wise = DB::select(
                        DB::raw("SELECT details_of_citizens.District, Hobby_id ,count(citizen_hobbies.id) as total 
                        FROM `citizen_hobbies` 
                        INNER JOIN details_of_citizens ON (details_of_citizens.id = citizen_hobbies.Citizen_id) 
                        group By details_of_citizens.District, Hobby_id"));

        return view('Hobby_wise',compact('Hobbies','Hobby_wise','district'));
    }

    public function Taluka_Hobby_wise($DistrictID)
    {
        if($DistrictID > 0)
        {
            $district=  DB::table("talukas")
                    ->select('talukas.id as ID','talukas.taluka_name as Name','talukas.id')
                    ->where("district_id",$DistrictID)
                    ->get();

            $Hobby_wise = DB::select(
                        DB::raw("SELECT details_of_citizens.Taluka as District, Hobby_id ,count(citizen_hobbies.id) as total 
                        FROM `citizen_hobbies` 
                        INNER JOIN details_of_citizens ON (details_of_citizens.id = citizen_hobbies.Citizen_id) 
                        where details_of_citizens.District = $DistrictID
                        group By details_of_citizens.Taluka, Hobby_id"));
        }

        else
        {
            $district=  DB::table("districts")
                    ->select('districts.id as ID','districts.name_of_district as Name')
                    ->get();

            $Hobby_wise = DB::select(
                        DB::raw("SELECT details_of_citizens.District, Hobby_id ,count(citizen_hobbies.id) as total 
                        FROM `citizen_hobbies` 
                        INNER JOIN details_of_citizens ON (details_of_citizens.id = citizen_hobbies.Citizen_id) 
                        group By details_of_citizens.District, Hobby_id"));
        }
        $Hobbies = DB::table("hobbies")
                        ->where("Active","1")
                        ->get();
        return view('Hobby_wise',compact('Hobbies','Hobby_wise','district'));
    }

    public function Village_Hobby_wise($talukaID)
    {
        if($talukaID > 0)
        {
            $district = DB::table("villages")
                ->select('villages.name_of_village as Name','villages.id as ID','villages.District_id','villages.Taluka_id')
                ->where('Taluka_id',$talukaID)
                ->where('Active','1')
                ->get();
            
            $Hobby_wise = DB::select(
                        DB::raw("SELECT details_of_citizens.Village as District, Hobby_id ,count(citizen_hobbies.id) as total 
                        FROM `citizen_hobbies` 
                        INNER JOIN details_of_citizens ON (details_of_citizens.id = citizen_hobbies.Citizen_id) 
                        where details_of_citizens.Taluka = $talukaID
                        group By details_of_citizens.Village, Hobby_id"));
        }
        $Hobbies = DB::table("hobbies")
                        ->where("Active","1")
                        ->get();
        return view('Hobby_wise',compact('Hobbies','Hobby_wise','district'));
    }





    public function Reports_tab1()
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
        $education = DB::table("education")
                    ->where('Active','1')
                    ->orderBy('sequence')
                    ->get();
        $home_type = DB::table("home_types")
                    ->where('Active','1')
                    ->get();
        $stove_type = DB::table("stove_types")
                    ->where('Active','1')
                    ->get();
        $bank_type = DB::table("bank_types")
                    ->where('Active','1')
                    ->get();
        $income_sources = DB::table("income_sources")
                    ->where('Active','1')
                    ->get();
        
        $home_count =  DB::select(
                    DB::raw("SELECT home_types.type_of_home, details_of_citizens.District, details_of_citizens.home_type, count(*) as total 
                    FROM details_of_citizens
                    INNER JOIN home_types ON (home_types.id = details_of_citizens.home_type) 
                    WHERE Active = 1 
                    GROUP BY details_of_citizens.District, home_types.type_of_home, details_of_citizens.home_type"));

        $education_count =  DB::select(
                    DB::raw("SELECT education.name_of_degree, details_of_citizens.District, details_of_citizens.Education, count(*) as total 
                    FROM details_of_citizens 
                    INNER JOIN education ON (education.id = details_of_citizens.Education) 
                    GROUP BY details_of_citizens.District, education.name_of_degree, details_of_citizens.Education"));
 
        $Own_House_YN = DB::table("details_of_citizens")                
                ->RightJoin('districts','districts.id','=','details_of_citizens.District')
				->select('districts.name_of_district','details_of_citizens.Own_house', DB::raw('count(*) as total'))
				->groupBy('details_of_citizens.Own_house','districts.name_of_district')
                ->orderBy('name_of_district')
                ->orderBy('Own_house')
				->get();

        $Bank_YN = DB::table("details_of_citizens")                
                ->RightJoin('districts','districts.id','=','details_of_citizens.District')
				->select('districts.name_of_district','details_of_citizens.Bank_account', DB::raw('count(*) as total'))
				->groupBy('details_of_citizens.Bank_account','districts.name_of_district')
                ->orderBy('name_of_district')
                ->orderBy('Bank_account')
				->get();

        $washroomWise = DB::table("details_of_citizens")                
                ->RightJoin('districts','districts.id','=','details_of_citizens.District')
                ->select('districts.name_of_district','details_of_citizens.Water_closet', DB::raw('count(*) as total'))
                ->groupBy('details_of_citizens.Water_closet','districts.name_of_district')
                ->orderBy('name_of_district')
                ->orderBy('Water_closet')
                ->get();

        $bathroomwise = DB::table("details_of_citizens")                
                ->RightJoin('districts','districts.id','=','details_of_citizens.District')
				->select('districts.name_of_district','details_of_citizens.Bathroom', DB::raw('count(*) as total'))
				->groupBy('details_of_citizens.Bathroom','districts.name_of_district')
                ->orderBy('name_of_district')
                ->orderBy('Bathroom')
				->get();

        $Landwise = DB::table("details_of_citizens")                
                ->RightJoin('districts','districts.id','=','details_of_citizens.District')
				->select('districts.name_of_district','details_of_citizens.Land_ownership', DB::raw('count(*) as total'))
				->groupBy('details_of_citizens.Land_ownership','districts.name_of_district')
                ->orderBy('name_of_district')
                ->orderBy('Land_ownership')
				->get();

        $LandDisputewise = DB::table("details_of_citizens")                
                ->RightJoin('districts','districts.id','=','details_of_citizens.District')
				->select('districts.name_of_district','details_of_citizens.Land_dispute', DB::raw('count(*) as total'))
                ->where('details_of_citizens.Land_ownership','=','Y')
				->groupBy('details_of_citizens.Land_dispute','districts.name_of_district')
                ->orderBy('name_of_district')
                ->orderBy('Land_dispute')
				->get();

        $BankTypeWise = DB::select(
                    DB::raw("SELECT bank_types.type_of_bank, details_of_citizens.District, details_of_citizens.Bank_type, count(*) as total 
                    FROM details_of_citizens 
                    INNER JOIN bank_types ON (bank_types.id = details_of_citizens.Bank_type) WHERE Active = 1 
                    GROUP BY details_of_citizens.District, bank_types.type_of_bank, details_of_citizens.bank_type"));
        
        $StoveTypeWise = DB::select(
                    DB::raw("SELECT stove_types.type_of_stove, details_of_citizens.District, details_of_citizens.stove_type, count(*) as total 
                    FROM details_of_citizens 
                    INNER JOIN stove_types ON (stove_types.id = details_of_citizens.stove_type) WHERE Active = 1 
                    GROUP BY details_of_citizens.District, stove_types.type_of_stove, details_of_citizens.stove_type"));
        
        $income_source_wise = DB::select(
                    DB::raw("SELECT income_sources.type_of_income_source, details_of_citizens.District, details_of_citizens.Income_source, count(*) as total 
                    FROM details_of_citizens 
                    INNER JOIN income_sources ON (income_sources.id = details_of_citizens.Income_source) WHERE Active = 1 
                    GROUP BY income_sources.type_of_income_source, details_of_citizens.District, details_of_citizens.Income_source"));
        
        return view('ReportsTab1',compact('Bank_YN','Own_House_YN','income_source_wise','income_sources','StoveTypeWise','BankTypeWise','education_count','LandDisputewise','Landwise','bathroomwise','washroomWise','home_count','education','district_count','district','taluka','home_type','stove_type','bank_type'));
    }

    public function Reports_tab2()
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

        $count = DB::select(
                    DB::raw("select districts.id as District_ID, count(details_of_citizens.District) as totalCount
                    From districts
                    INNER JOIN details_of_citizens ON (details_of_citizens.District = districts.id) 
                    group By districts.id, details_of_citizens.District"));

        $member_count = DB::select(
                    DB::raw("SELECT districts.id as District_id, COUNT(distinct members.Citizen_id) as total
                            FROM details_of_citizens 
                            Right join districts ON (details_of_citizens.District = districts.id)
                            RIGHT JOIN members ON (details_of_citizens.id = members.Citizen_id)
                            where members.lives_with_you = 'Y'
                            GROUP BY districts.id"));

        return view('ReportsTab2',compact('count','member_count','district','taluka'));
    }

    public function Reports_tab3()
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
        $diseases = DB::table("diseases")
                    ->where('Active','1')
                    ->get();
        
        $Hospital_type = DB::table('hospital_types')
                    ->where('Active','1')
                    ->get();

        $handicap_types = DB::table('handicap_types')
                    ->where('Active','1')
                    ->get();

        $daily_chores = DB::table('help_types')
                    ->where('Active','1')
                    ->get();

        $Disease_YN = DB::table("details_of_citizens")                
                ->RightJoin('districts','districts.id','=','details_of_citizens.District')
				->select('districts.name_of_district','details_of_citizens.any_disease', DB::raw('count(*) as total'))
				->groupBy('details_of_citizens.any_disease','districts.name_of_district')
                ->orderBy('name_of_district')
                ->orderBy('any_disease')
				->get();

        $Disease_wise = DB::select(
                    DB::raw("SELECT details_of_citizens.District, Disease_id ,count(citizen_diseases.id) as total 
                    FROM `citizen_diseases` 
                    INNER JOIN details_of_citizens ON (details_of_citizens.id = citizen_diseases.Citizen_id) 
                    group By details_of_citizens.District, Disease_id"));
        
        $RegularCheckupWise = DB::table("details_of_citizens")                
                ->RightJoin('districts','districts.id','=','details_of_citizens.District')
				->select('districts.name_of_district','details_of_citizens.Regular_check_up', DB::raw('count(*) as total'))
				->groupBy('details_of_citizens.Regular_check_up','districts.name_of_district')
                ->orderBy('name_of_district')
                ->orderBy('Regular_check_up')
				->get();

        $Handicap_YN = DB::table("details_of_citizens")                
                ->RightJoin('districts','districts.id','=','details_of_citizens.District')
				->select('districts.name_of_district','details_of_citizens.are_you_handicapped', DB::raw('count(*) as total'))
				->groupBy('details_of_citizens.are_you_handicapped','districts.name_of_district')
                ->orderBy('name_of_district')
                ->orderBy('are_you_handicapped')
				->get();
        
        $Hancicap_wise = DB::select(
                    DB::raw("SELECT details_of_citizens.District, Handicap_id ,count(citizen_handicaps.id) as total 
                    FROM `citizen_handicaps` 
                    INNER JOIN details_of_citizens ON (details_of_citizens.id = citizen_handicaps.Citizen_id) 
                    group By details_of_citizens.District, Handicap_id"));

        $Hospital_Type_Wise = DB::select(
                    DB::raw("SELECT hospital_types.type_of_hospital, details_of_citizens.District, details_of_citizens.Hospital_type, count(*) as total 
                    FROM details_of_citizens 
                    INNER JOIN hospital_types ON (hospital_types.id = details_of_citizens.Hospital_type) WHERE Active = 1 
                    GROUP BY hospital_types.type_of_hospital, details_of_citizens.District, details_of_citizens.Hospital_type"));

        $Daily_Chores_wise = DB::table("details_of_citizens")                
                ->RightJoin('districts','districts.id','=','details_of_citizens.District')
				->select('districts.name_of_district','details_of_citizens.District','details_of_citizens.daily_chores', DB::raw('count(*) as total'))
				->groupBy('details_of_citizens.daily_chores','districts.name_of_district','details_of_citizens.District')
                ->orderBy('name_of_district')
				->get();

        // echo "<pre>";
        // print_r($Daily_Chores_wise);
        // die();
        
        return view ('ReportsTab3',compact('Daily_Chores_wise','Hancicap_wise','Handicap_YN','Disease_wise','Disease_YN','Hospital_Type_Wise','RegularCheckupWise','daily_chores','handicap_types','Hospital_type','diseases','district','taluka'));
    }

    public function Reports_tab4()
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
        $rationCard = DB::table('ration_card_types')
                    ->where('Active','1')
                    ->get();
        
        $AadharWise = DB::table("details_of_citizens")                
                ->RightJoin('districts','districts.id','=','details_of_citizens.District')
				->select('districts.name_of_district','details_of_citizens.aadhar_card', DB::raw('count(*) as total'))
				->groupBy('details_of_citizens.aadhar_card','districts.name_of_district')
                ->orderBy('name_of_district')
                ->orderBy('aadhar_card')
				->get();

        $AadharDiscrepancyWise = DB::table("details_of_citizens")                
                ->RightJoin('districts','districts.id','=','details_of_citizens.District')
				->select('districts.name_of_district','details_of_citizens.aadhar_discrepancy', DB::raw('count(*) as total'))
				->groupBy('details_of_citizens.aadhar_discrepancy','districts.name_of_district')
                ->orderBy('name_of_district')
                ->orderBy('aadhar_discrepancy')
				->get();

        // echo "<pre>";
        // print_r($AadharDiscrepancyWise);
        // die();
        
        $VoterIdWise = DB::table("details_of_citizens")                
                ->RightJoin('districts','districts.id','=','details_of_citizens.District')
				->select('districts.name_of_district','details_of_citizens.Voter_id', DB::raw('count(*) as total'))
				->groupBy('details_of_citizens.Voter_id','districts.name_of_district')
                ->orderBy('name_of_district')
                ->orderBy('Voter_id')
				->get();

        $STPassWise = DB::table("details_of_citizens")                
                ->RightJoin('districts','districts.id','=','details_of_citizens.District')
				->select('districts.name_of_district','details_of_citizens.ST_pass', DB::raw('count(*) as total'))
				->groupBy('details_of_citizens.ST_pass','districts.name_of_district')
                ->orderBy('name_of_district')
                ->orderBy('ST_pass')
				->get();

        $RationCard_wise =  DB::select(
                    DB::raw("SELECT ration_card_types.type_of_ration_card, details_of_citizens.District, details_of_citizens.Ration_card, count(*) as total 
                    FROM details_of_citizens 
                    INNER JOIN ration_card_types ON (ration_card_types.id = details_of_citizens.Ration_card) 
                    WHERE Active = 1 
                    GROUP BY details_of_citizens.District, ration_card_types.type_of_ration_card, details_of_citizens.Ration_card"));

        $count = DB::select(
                    DB::raw("select districts.id as District_ID, count(details_of_citizens.District) as totalCount
                    From districts
                    INNER JOIN details_of_citizens ON (details_of_citizens.District = districts.id) 
                    group By districts.id, details_of_citizens.District"));

        $No_Ration_card = DB::select(
                    DB::raw("select details_of_citizens.District as District_id, count(details_of_citizens.Ration_card) as total
                    From districts
                    RIGHT JOIN details_of_citizens ON (details_of_citizens.District = districts.id) 
                    where details_of_citizens.Ration_card = '1'
                    group By details_of_citizens.District, details_of_citizens.Ration_card"));

        //echo "<pre>";
        // print_r($count);
        //print_r($No_Ration_card);
        //die();
        
        return view ('ReportsTab4',compact('No_Ration_card','count','RationCard_wise','STPassWise','VoterIdWise','AadharDiscrepancyWise','AadharWise','district','taluka','rationCard'));
    }

    public function Reports_tab5()
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

        $schemes = DB::table("govt_scheme_types")
                ->where('Active','1')
                ->get();

        $SchemeWise = DB::select(
            DB::raw("SELECT details_of_citizens.District, Govt_scheme_id,count(citizen_govt_schemes.id) as total
            FROM `citizen_govt_schemes` 
            INNER JOIN details_of_citizens ON (details_of_citizens.id = citizen_govt_schemes.Citizen_id) 
            group By details_of_citizens.District, Govt_scheme_id"));

        $SchemeAvail = DB::table("details_of_citizens")                
                ->RightJoin('districts','districts.id','=','details_of_citizens.District')
                ->select('districts.name_of_district','details_of_citizens.Govt_schemes', DB::raw('count(*) as total'))
                ->groupBy('details_of_citizens.Govt_schemes','districts.name_of_district')
                ->orderBy('name_of_district')
                ->orderBy('Govt_schemes')
                ->get();

        // echo "<pre>";
        // print_r($SchemeAvail);
        // die();

        return view ('ReportsTab5',compact('SchemeAvail','SchemeWise','schemes','district','taluka'));
    }

    public function Reports_tab6()
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
        $income_increase = DB::table("work_types")
                        ->where("Active","1")
                        ->get();

        $tools = DB::table("tool_types")
                        ->where("Active","1")
                        ->get();
        
        $mediacl_instruments = DB::table("medical_equipment_types")
                        ->where("Active","1")
                        ->get();

        $social_service = DB::table("social_service_types")
                        ->where("Active","1")
                        ->get();

        $teaching_skills = DB::table("teaching_skills")
                        ->where("Active","1")
                        ->get();

        $Hobbies = DB::table("hobbies")
                        ->where("Active","1")
                        ->get();

        $income_increase_YN = DB::table("details_of_citizens")                
                ->RightJoin('districts','districts.id','=','details_of_citizens.District')
                ->select('districts.name_of_district','details_of_citizens.income_increase', DB::raw('count(*) as total'))
                ->groupBy('details_of_citizens.income_increase','districts.name_of_district')
                ->orderBy('name_of_district')
                ->orderBy('income_increase')
                ->get();

        $Work_type_wise = DB::select(
                DB::raw("SELECT details_of_citizens.District, Work_type_id ,count(citizen_work_types.id) as total
                    FROM `citizen_work_types` 
                    INNER JOIN details_of_citizens ON (details_of_citizens.id = citizen_work_types.Citizen_id) 
                    group By details_of_citizens.District, Work_type_id"));

        $Tools_YN = DB::table("details_of_citizens")                
                ->RightJoin('districts','districts.id','=','details_of_citizens.District')
                ->select('districts.name_of_district','details_of_citizens.tools_required', DB::raw('count(*) as total'))
                ->groupBy('details_of_citizens.tools_required','districts.name_of_district')
                ->orderBy('name_of_district')
                ->orderBy('tools_required')
                ->get();

        $Tool_wise = DB::select(
                DB::raw("SELECT details_of_citizens.District, Tool_type_id ,count(citizen_tools.id) as total 
                FROM `citizen_tools` 
                INNER JOIN details_of_citizens ON (details_of_citizens.id = citizen_tools.Citizen_id) 
                group By details_of_citizens.District, Tool_type_id"));

        $Medical_equipment_wise = DB::select(
                DB::raw("SELECT details_of_citizens.District, medical_equipment_id ,count(citizen_medical_equipments.id) as total 
                FROM `citizen_medical_equipments` 
                INNER JOIN details_of_citizens ON (details_of_citizens.id = citizen_medical_equipments.Citizen_id) 
                group By details_of_citizens.District, medical_equipment_id"));

        $Social_service_YN = DB::table("details_of_citizens")                
                ->RightJoin('districts','districts.id','=','details_of_citizens.District')
                ->select('districts.name_of_district','details_of_citizens.social_service', DB::raw('count(*) as total'))
                ->groupBy('details_of_citizens.social_service','districts.name_of_district')
                ->orderBy('name_of_district')
                ->orderBy('social_service')
                ->get();

        $social_service_wise = DB::select(
                DB::raw("SELECT details_of_citizens.District, social_service_id ,count(citizen_social_services.id) as total 
                FROM `citizen_social_services` 
                INNER JOIN details_of_citizens ON (details_of_citizens.id = citizen_social_services.Citizen_id) 
                group By details_of_citizens.District, social_service_id"));

        $Teaching_skill_wise = DB::select(
                DB::raw("SELECT details_of_citizens.District, teaching_skill_id ,count(citizen_teaching_skills.id) as total 
                FROM `citizen_teaching_skills` 
                INNER JOIN details_of_citizens ON (details_of_citizens.id = citizen_teaching_skills.Citizen_id) 
                group By details_of_citizens.District, teaching_skill_id"));

        $Hobby_wise = DB::select(
                DB::raw("SELECT details_of_citizens.District, Hobby_id ,count(citizen_hobbies.id) as total 
                FROM `citizen_hobbies` 
                INNER JOIN details_of_citizens ON (details_of_citizens.id = citizen_hobbies.Citizen_id) 
                group By details_of_citizens.District, Hobby_id"));

        
        return view ('ReportsTab6',compact('Hobby_wise','Teaching_skill_wise','social_service_wise','Social_service_YN','Medical_equipment_wise','Tools_YN','Tool_wise','income_increase_YN','Work_type_wise','district','taluka','income_increase','tools','mediacl_instruments','social_service','teaching_skills','Hobbies'));
    }
}