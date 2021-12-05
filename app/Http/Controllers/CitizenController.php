<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income_source;
use App\Models\home_type;
use App\Models\stove_type;
use App\Models\bank_type;
use App\Models\disease;
use App\Models\hospital_type;
use App\Models\handicap_type;
use App\Models\help_type;
use App\Models\ration_card_type;
use App\Models\govt_scheme_type;
use App\Models\work_type;
use App\Models\tool_type;
use App\Models\medical_equipment_type;
use App\Models\social_service_types;
use App\Models\teaching_skills;
use App\Models\hobbies;
use App\Models\education;
use App\Models\relations;
use App\Models\district;
use App\Models\taluka;
use App\Models\village;
use App\Models\details_of_citizen;
use App\Models\members;
use App\Models\Handicap_percentage;
use App\Models\citizen_handicap;
use App\Models\citizen_work_type;
use App\Models\citizen_tool;
use App\Models\citizen_govt_schemes;
use App\Models\citizen_social_service;
use App\Models\citizen_teaching_skill;
use App\Models\citizen_disease;
use App\Models\citizen_hobbies;
use App\Models\citizen_medical_equipment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use DateTime;
use Carbon\Carbon;
use App\Exports\CitizenExport;
use Excel;
use PDF;

class CitizenController extends Controller
{
    public function tab1($id)
    {
        if(in_array('1_1',session('access')))
        {
            if($id>0)
            {
                Session::put('id', $id);
                $c = DB::table('details_of_citizens')
                ->where('id', $id)
                ->get();
                $t= DB::table('talukas')
                ->where('district_id', $c[0]->District)
                ->get();
                $v= DB::table('villages')
                ->where('Taluka_id', $c[0]->Taluka)
                ->get();    
            }
            else
            {
                Session::forget('id');
                $c='';
                $t='';
                $v='';
            }
            $c = DB::table('details_of_citizens')
                    ->where('id', $id)
                    ->get();
            $income_source=DB::table("income_sources")
                    ->where('Active','1')
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
            $education = DB::table("education")
                    ->where('Active','1')
                    ->get();
            $district = DB::table("districts")
                    ->where('id',Auth::user()->district_id)
                    ->pluck("name_of_district","id");
            $t = DB::table("talukas")
                    ->where('id',Auth::user()->taluka_id)
                    ->pluck("taluka_name","id");
            $v = DB::table("villages")
                    ->where('taluka_id',Auth::user()->taluka_id)
                    ->pluck("name_of_village","id");
            return view('citizen_tab_1',compact('id','v','t','c','income_source','home_type','stove_type','bank_type','education','district'));
        }
        else
        {
            return view('unauth');
        }        
    }

    public function tab2()
    {
        $Lastid = DB::getPdo()->lastInsertId();
        if(in_array('1_1',session('access')))
        {
            if(!Session::has('id'))
            {
                return redirect('/citizen/tab1/0');
            }
            $id = session::get('id');
            $relations = DB::table("relations")
                    ->where('Active','1')
                    ->get();
            
            $c = DB::table('members')
                ->where('Citizen_id', $id)
                ->join('relations','relations.id', '=', 'members.Relation')
                ->select('relations.id', 'members.id', 'members.Relation', 'members.name_of_member', 'members.Citizen_id',
                'members.occupation', 'members.lives_with_you', 'members.Mobile_no','relations.type_of_relation')
                ->get()
                ->toarray();

            return view('citizen_tab_2',compact('relations','c','Lastid'));
        }
        else
        {
            return view('unauth');
        }
    }

    public function tab3()
    {
        $Lastid = DB::getPdo()->lastInsertId();
        if(in_array('1_1',session('access')))
        {
            $id = session::get('id');
            $Page_id = details_of_citizen::where('id', $id)->pluck('Page_count')->first();
            Session::put('id', $id);
            if(!Session::has('id'))
            {
                return redirect('/citizen/tab1/0');
            }
            if($Page_id < 1)
            {
                return redirect('/citizen/tab2');
            }
            $id = session::get('id');
            if($id>0)
            {
                $c = DB::table('details_of_citizens')
                    ->where('id', $id)
                    ->get();

                $d= DB::table('citizen_diseases')
                    ->where('Citizen_id', $id)
                    ->get();
                $citizen_diseases = array();
                $disease_start_date = array();
                $i=0;
                foreach($d as $dd)
                {
                    $citizen_diseases[$i]= $dd->Disease_id;
                    $disease_start_date[$i] = $dd->Disease_start_date;
                    $i++;
                }
                $h = DB::table('citizen_handicaps')
                ->where('Citizen_id', $id)
                ->get();
            }
            else
            {
                $c='';
                $d='';
                $h='';
            }
            $diseases = DB::table("diseases")
                    ->where('Active','1')
                    ->get();
            $hospital_type = DB::table("hospital_types")
                    ->where('Active','1')
                    ->get();
            $handicap_type = DB::table("handicap_types")
                    ->where('Active','1')
                    ->get();
            $help_type = DB::table("help_types")
                    ->where('Active','1')
                    ->get();
            return view('citizen_tab_3',compact('id','disease_start_date','citizen_diseases','c','h','diseases','hospital_type','handicap_type','help_type'));
        }
        else
        {
            return view ('unauth');
        }
    }

    public function tab4()
    {
        if(in_array('1_1',session('access')))
        {
            $id = session::get('id');
            $Page_id = details_of_citizen::where('id', $id)->pluck('Page_count')->first();
            if( !Session::has('id') )
            {
                return redirect('/citizen/tab1/0');
            }
            if($Page_id < 3)
            {
                return redirect('/citizen/tab3');
            }   
            $id = session::get('id');
            $c = DB::table('details_of_citizens')
                    ->where('id', $id)
                    ->get();
            $ration_card_type = DB::table("ration_card_types")
                    ->where('Active','1')
                    ->get();
            return view('citizen_tab_4',compact('c','ration_card_type','id'));
        }
        else
        {
            return view ('unauth');
        }
    }

    public function tab5()
    {
        if(in_array('1_1',session('access')))
        {
            $id = session::get('id');
            $Page_id = details_of_citizen::where('id', $id)->pluck('Page_count')->first();
            if(!Session::has('id'))
            {
                return redirect('/citizen/tab1/0');
            }
            if($Page_id < 4)
            {
                return redirect('/citizen/tab4');
            }   
            $id = session::get('id');
            $c = DB::table('details_of_citizens')
                ->where('id', $id)
                ->get();
            
            $citizen_schemes = array();
            $cs = DB::table('citizen_govt_schemes')
                ->where('Citizen_id', $id)
                ->get();
            $j=0;
            foreach($cs as $css)
            {
                $citizen_schemes[$j]= $css->Govt_scheme_id;
                $j++;
            }
            $govt_scheme_type= DB::table("govt_scheme_types")
                    ->where('Active','1')
                    ->get();
            return view('citizen_tab_5',compact('c','govt_scheme_type','citizen_schemes'));
        }
        else
        {
            return view ('unauth');
        }
    }

    public function tab6()
    {
        if(in_array('1_1',session('access')))
        {   
            $id = session::get('id');
            $Page_id = details_of_citizen::where('id', $id)->pluck('Page_count')->first();
            if(!Session::has('id'))
            {
                return redirect('/citizen/tab1/0');
            }
            if($Page_id < 5)
            {
                return redirect('/citizen/tab5');
            }   
            $id = session::get('id');
            $c = DB::table('details_of_citizens')
                ->where('id', $id)
                ->get();

            $income_increase = array();
            $ii = DB::table('citizen_work_types')
                                ->where('Citizen_id', $id)
                                ->get();
            $k= 0;
            foreach($ii as $iii)
            {
                $income_increase[$k] = $iii->Work_type_id;
                $k++;
            }

            $tool = array();
            $t = DB::table('citizen_tools')
                    ->where('Citizen_id', $id)
                    ->get();
            $i=0;

            foreach($t as $tt)
            {
                $tool[$i] = $tt->Tool_type_id;
                $i++;
            }
            
            $medical_equipment=array();
            $meq = DB::table('citizen_medical_equipments')
                        ->where('Citizen_id', $id)
                        ->get();
            $i=0;
            foreach($meq as $me)
            {
                $medical_equipment[$i] = $me->medical_equipment_id;
                $i++;
            }

            $social = array();
            $soc= DB::table('citizen_social_services')
                    ->where('Citizen_id', $id)
                    ->get();
            $i=0;
            foreach($soc as $so)
            {
                $social[$i] = $so->social_service_id;
                $i++;
            }

            $teaching = array();
            $tea= DB::table('citizen_teaching_skills')
                    ->where('Citizen_id', $id)
                    ->get();
            $i=0;
            foreach($tea as $te)
            {
                $teaching[$i] = $te->teaching_skill_id;
                $i++;
            }

            $hobby = array();
            $ho= DB::table('citizen_hobbies')
                    ->where('Citizen_id', $id)
                    ->get();
            $i=0;
            foreach($ho as $hoo)
            {
                $hobby[$i] = $hoo->Hobby_id;
                $i++;
            }

            $work_type= DB::table("work_types")
                    ->where('Active','1')
                    ->get();
            $tool_type = DB::table("tool_types")
                    ->where('Active','1')
                    ->get();
            $medical_equipment_type = DB::table("medical_equipment_types")
                    ->where('Active','1')
                    ->get();
            $social_service_types = DB::table("social_service_types")
                    ->where('Active','1')
                    ->get();
            $teaching_skills= DB::table("teaching_skills")
                    ->where('Active','1')
                    ->get();
            $hobbies = DB::table("hobbies")
                    ->where('Active','1')
                    ->get();
            return view('citizen_tab_6',compact('hobby','teaching','social','medical_equipment','tool','income_increase','c','work_type','tool_type','medical_equipment_type','social_service_types','teaching_skills','hobbies'));
        }
        else
        {
            return view ('unauth');
        }
    }

    public function insertTab1(request $request)
    {
        if(in_array('1_1',session('access')))
        {
            $id = session::get('id');
            $User_id = session::get('User_id');
            $date = Carbon::now();
            $DateTime = $date->toDateTimeString();
            if(Session::has('id'))
            {
                if($request->Own_house == 'N')
                {
                    $request->home_type = '7';
                }
                if($request->Bank_account == 'N')
                {
                    $request->Bank_type = '7';
                }
                $details_of_citizens = details_of_citizen::find($id)->update([
                    'Full_name'=>$request->Full_name,
                    'date_of_birth'=>$request->date_of_birth,
                    'Education'=>$request->Education,
                    'Complete_address'=>$request->Complete_address,
                    'District'=>$request->district, 
                    'Taluka'=>$request->taluka,
                    'Village'=>$request->village,
                    'Mobile_no'=>$request->Mobile_no,
                    'Income_source'=>$request->Income_source,
                    'Own_house'=>$request->Own_house,
                    'home_type'=>$request->home_type,
                    'Water_closet'=>$request->Water_closet,
                    'Bathroom'=>$request->Bathroom,
                    'stove_type'=>$request->stove_type,
                    'Land_ownership'=>$request->Land_ownership,
                    'Land_dispute'=>$request->Land_dispute,
                    'Bank_account'=>$request->Bank_account,
                    'Bank_type'=>$request->Bank_type, 
                    'Last_updated_at'=>$DateTime,
                    'Last_updated_by'=>$User_id,
                    'Page_count'=>'1',
                ]); 
                return $id;
            }
            else
            {
                if($request->Own_house == 'N')
                {
                    $request->home_type = '7';
                }
                if($request->Bank_account == 'N')
                {
                    $request->Bank_type = '7';
                }
                $details_of_citizens = details_of_citizen::insert([
                    'Full_name'=>$request->Full_name,
                    'date_of_birth'=>$request->date_of_birth,
                    'Education'=>$request->Education,
                    'Complete_address'=>$request->Complete_address,
                    'District'=>$request->district, 
                    'Taluka'=>$request->taluka,
                    'Village'=>$request->village,
                    'Mobile_no'=>$request->Mobile_no,
                    'Income_source'=>$request->Income_source,
                    'Own_house'=>$request->Own_house,
                    'home_type'=>$request->home_type,
                    'Water_closet'=>$request->Water_closet,
                    'Bathroom'=>$request->Bathroom,
                    'stove_type'=>$request->stove_type,
                    'Land_ownership'=>$request->Land_ownership,
                    'Land_dispute'=>$request->Land_dispute,
                    'Bank_account'=>$request->Bank_account,
                    'Bank_type'=>$request->Bank_type,                    
                    'created_by'=>$User_id,
                    'Page_count'=>'1',
                ]);

                $Lastid=DB::getPdo()->lastInsertId();
                $request->session()->put('id',$Lastid);
                return $Lastid;
            }
        }
        else
        {
            return view ('unauth');
        }
    }

    public function insertTab2(request $request)
    {
        if(in_array('1_1',session('access')))
        {
            $Lastid = DB::getPdo()->lastInsertId();
            $User_id = session::get('User_id');
            $date = Carbon::now();
            $DateTime = $date->toDateTimeString();
            $id = session::get('id');
            if($request->id == '')
            {
                $members= members::insert([
                    'Citizen_id'=>$id,
                    'name_of_member'=>$request->name_of_member,
                    'Relation'=>$request->Relation,
                    'occupation'=>$request->occupation,
                    'lives_with_you'=>$request->lives_with_you,
                    'Mobile_no'=>$request->Mobile_no,
                    'created_by'=>$User_id,
                ]);
            }   

            else
            {
                $members= members::find($request->id)->update([
                    'Citizen_id'=>$id,
                    'name_of_member'=>$request->name_of_member,
                    'Relation'=>$request->Relation,
                    'occupation'=>$request->occupation,
                    'lives_with_you'=>$request->lives_with_you,
                    'Mobile_no'=>$request->Mobile_no,
                    'Last_updated_at'=>$DateTime,
                    'Last_updated_by'=>$User_id,
                ]);
                // $details_of_citizens = details_of_citizen::insert([
                //     'Page_count'=>'2',
                // ]);
            }

            $c = DB::table('members')
                ->where('Citizen_id', $id)
                ->join('relations','relations.id', '=', 'members.Relation')
                ->select('relations.id', 'members.id', 'members.name_of_member','members.Relation', 'members.occupation', 'members.Citizen_id', 
                'members.lives_with_you', 'members.Mobile_no','relations.type_of_relation')
                ->get()
                ->toarray();
            
            return view('ListMembers',compact('c','Lastid'));
        }
        else
        {
            return view ('unauth');
        }
    }

    public function insertTab3(request $request)
    {
        if(in_array('1_1',session('access')))
        {
            $User_id = session::get('User_id');
            $date = Carbon::now();
            $DateTime = $date->toDateTimeString();
            $id = Session::get('id');
            $update = details_of_citizen::find($id)->update([
                'any_disease'=>$request->any_disease,
                'Regular_check_up'=>$request->Regular_check_up,
                'Hospital_type'=>$request->Hospital_type,
                'are_you_handicapped'=>$request->are_you_handicapped,
                'daily_chores'=>$request->daily_chores,
                'Last_updated_at'=>$DateTime,
                'Last_updated_by'=>$User_id,
                'Page_count'=>'3',
            ]);
            $id = Session::get('id');
            $disease_start_date=array();
            if($request->Disease_start_date !='' && count($request->Disease_start_date)>0)
            {
                foreach($request->Disease_start_date as $key=>$value)
                {
                    if($value!='')
                    {
                        $disease_start_date[]=$value;
                    }
                }
            }
            
            DB::delete('delete from citizen_diseases where Citizen_id = ?',[$id]);
            if($request->which_diseases !='')
            {
                foreach ($request->which_diseases as $key=>$value)
                {
                    $citizen_diseases = citizen_disease::insert([
                        'Disease_id'=>$value,
                        'Citizen_id'=>$id, 
                        'Disease_start_date'=>$disease_start_date[$key],
                        'Last_updated_at'=>$DateTime,
                        'Last_updated_by'=>$User_id,
                        'created_by'=>$User_id,
                    ]);
                }    
            }

            DB::delete('delete from citizen_handicaps where Citizen_id = ?',[$id]);
            if($request->are_you_handicapped == 'Y')
            {
                $citizen_handicap = citizen_handicap::insert([
                    'Citizen_id'=>$id,
                    'Handicap_id'=>$request->Handicap_id,
                    'Handicap_percentage'=>$request->Handicap_percentage,
                    'created_by'=>$User_id,
                    'Last_updated_at'=>$DateTime,
                    'Last_updated_by'=>$User_id,
                ]);
            }
        }
        else
        {
            return view ('unauth');
        }
    }

    public function insertTab4(request $request)
    {
        if(in_array('1_1',session('access')))
        {
            $User_id = session::get('User_id');
            $date = Carbon::now();
            $DateTime = $date->toDateTimeString();
            $id = Session::get('id');

            if($request->aadhar_card == 'N')
            {
                $request->aadhar_discrepancy = '';
            }
            
            $update = details_of_citizen::find($id)->update([
                'aadhar_card'=>$request->aadhar_card,
                'aadhar_discrepancy'=>$request->aadhar_discrepancy,
                'Voter_id'=>$request->Voter_id,	
                'Ration_card'=>$request->Ration_card,
                'ST_pass'=>$request->ST_pass,
                'Last_updated_at'=>$DateTime,
                'Last_updated_by'=>$User_id,
                'Page_count'=>'4',
            ]);
        }
        else
        {
            return view ('unauth');
        }
    }

    public function insertTab5(request $request)
    {
       if(in_array('1_1',session('access')))
        {    
            $User_id = session::get('User_id');
            $date = Carbon::now();
            $DateTime = $date->toDateTimeString();
            $id = Session::get('id');  
            $update = details_of_citizen::find($id)->update([
                'Govt_schemes'=>$request->Govt_schemes,
                'Page_count'=>'5',
            ]);
            DB::delete('delete from citizen_govt_schemes where Citizen_id = ?',[$id]);
            if($request->Govt_schemes =='Y' && count($request->Govt_scheme_name)>0)
            {
                foreach ($request->Govt_scheme_name as $key=>$value)
                {
                    $citizen_govt_schemes= citizen_govt_schemes::insert([
                        'Govt_scheme_id'=>$value,
                        'Citizen_id'=>$id,                        
                        'created_by'=>$User_id ,
                        'Last_updated_at'=>$DateTime,
                        'Last_updated_by'=>$User_id,
                        'Last_updated_at'=>$DateTime,
                        'Last_updated_by'=>$User_id,
                    ]);
                }        
            }
        }
        else
        {
            return view ('unauth');
        }    
    }

    public function insertTab6(request $request)
    {
        if(in_array('1_1',session('access')))
        {  
            $User_id = session::get('User_id');
            $date = Carbon::now();
            $DateTime = $date->toDateTimeString();
            $id = Session::get('id');
            $update = details_of_citizen::find($id)->update([
                'income_increase'=>$request->income_increase,
                'tools_required'=>$request->tools_required,
                'social_service'=>$request->social_service,
                'any_comment'=>$request->comments,
                'any_difficulties'=>$request->difficulties,
                'designated_officer_name'=>$request->designated_officer_name,
                'designated_officer_contact_no'=>$request->designated_officer_contact_no,
                'Last_updated_at'=>$DateTime,
                'Last_updated_by'=>$User_id,
                'Page_count'=>'6',
            ]);
            
            DB::delete('delete from citizen_work_types where Citizen_id = ?',[$id]);
            if($request->income_increase == 'Y' && count($request->Work_type)>0)
            {
                foreach ($request->Work_type as $key=>$value)
                {
                    $citizen_work_type= citizen_work_type::insert([
                        'Work_type_id'=>$value,
                        'Citizen_id'=>$id,
                        'created_by'=>$User_id ,
                        'Last_updated_at'=>$DateTime,
                        'Last_updated_by'=>$User_id,
                    ]);
                }
            }
            DB::delete('delete from citizen_tools where Citizen_id = ?',[$id]);
            if($request->tools_required == 'Y' && count($request->Tool_type)>0 && count($request->Tool_type)>0)
            {
                foreach ($request->Tool_type as $key=>$value)
                {
                    $citizen_tool = citizen_tool::insert([
                        'Tool_type_id'=>$value,
                        'Citizen_id'=>$id,
                        'created_by'=>$User_id ,
                        'Last_updated_at'=>$DateTime,
                        'Last_updated_by'=>$User_id,
                    ]);
                }
            }
            
            DB::delete('delete from citizen_medical_equipments where Citizen_id = ?',[$id]);
            if($request->medical_equipment!='' && count($request->medical_equipment)>0)
            {
                foreach ($request->medical_equipment as $key=>$value)
                {
                    $citizen_medical_equipment = citizen_medical_equipment::insert([
                        'medical_equipment_id'=>$value,
                        'Citizen_id'=>$id,
                        'created_by'=>$User_id ,
                        'Last_updated_at'=>$DateTime,
                        'Last_updated_by'=>$User_id,
                    ]);
                }
            }
            
            DB::delete('delete from citizen_social_services where Citizen_id = ?',[$id]);
            if($request->social_service == 'Y' && $request->social_service_type!= '' && count($request->social_service_type)>0)
            {
                foreach ($request->social_service_type as $key=>$value)
                {
                    $citizen_social_service = citizen_social_service::insert([
                        'social_service_id'=>$value,
                        'Citizen_id'=>$id,
                        'created_by'=>$User_id ,
                        'Last_updated_at'=>$DateTime,
                        'Last_updated_by'=>$User_id,
                    ]);
                }
            }
            
            DB::delete('delete from citizen_teaching_skills where Citizen_id = ?',[$id]);
            if($request->teaching_skills!='' && count($request->teaching_skills)>0)
            {
                foreach ($request->teaching_skills as $key=>$value)
                {
                    $citizen_teaching_skill = citizen_teaching_skill::insert([
                        'teaching_skill_id'=>$value,
                        'Citizen_id'=>$id,
                        'created_by'=>$User_id ,
                        'Last_updated_at'=>$DateTime,
                        'Last_updated_by'=>$User_id,
                    ]);
                }
            }
            
            DB::delete('delete from citizen_hobbies where Citizen_id = ?',[$id]);
            if($request->Hobbies!='' && count($request->Hobbies)>0)
            {
                foreach ($request->Hobbies as $key=>$value)
                {
                    $citizen_hobbies=citizen_hobbies::insert([
                        'Hobby_id'=>$value,
                        'Citizen_id'=>$id,
                        'created_by'=>$User_id ,
                        'Last_updated_at'=>$DateTime,
                        'Last_updated_by'=>$User_id,
                    ]);
                }
            }
            return $id;
        }
        else
        {
            return view ('unauth');
        }
    }   

    // public function deleteCitizen($id)
    // {
    //     DB::delete('delete from citizen_work_types where Citizen_id = ?',[$id]);
    //     DB::delete('delete from citizen_tools where Citizen_id = ?',[$id]);
    //     DB::delete('delete from citizen_medical_equipments where Citizen_id = ?',[$id]);
    //     DB::delete('delete from citizen_social_services where Citizen_id = ?',[$id]);
    //     DB::delete('delete from citizen_teaching_skills where Citizen_id = ?',[$id]);
    //     DB::delete('delete from citizen_hobbies where Citizen_id = ?',[$id]);
    // }

    public function deleteMember($id)
    {
        if(in_array('1_1',session('access')))
        { 
            $citizen_id = session::get('id');
            DB::delete('delete from members where id = ?',[$id]);
            $c = DB::table('members')
                ->where('Citizen_id', $citizen_id)     
                ->join('relations','relations.id', '=', 'members.Relation')
                 ->select('relations.id', 'members.id', 'members.name_of_member', 'members.Relation', 'members.occupation', 'members.lives_with_you', 
                 'members.name_of_member','members.Mobile_no','relations.type_of_relation')
                ->get();
            
            return view('ListMembers',compact('c'));
        }
        else
        {
            return view ('unauth');
        }
    }

    public function ListTab2()
    {
        if(in_array('1_2',session('access')))
        { 
            $members = members::all();
            $relations = relations::all();
            return view('citizen_tab_2',compact('members','relations'));
        }
        else
        {
            return view ('unauth');
        }
    }

    public function myformAjax($id)
    {
        $talukas = DB::table("talukas")
                    ->where("district_id",$id)
                    ->pluck("taluka_name","id");
		return json_encode($talukas);
    }

    public function myVillage($id)
    {
        return $villages = DB::table("villages")
                    ->where("taluka_id",$id)
                    ->pluck("name_of_village","id");
		return json_encode($villages);
    }

    public function list()
    {
        if(in_array('1_2',session('access')))
        {
            $id = session::get('id');
            $c = DB::table('details_of_citizens')
                    ->where('id', $id)
                    ->get();
            $district = DB::table("districts")
                    ->where('id',Auth::user()->district_id)
                    ->pluck("name_of_district","id");
            $t = DB::table("talukas")
                    ->where('id',Auth::user()->taluka_id)
                    ->pluck("taluka_name","id");
            $v = DB::table("villages")
                    ->where('taluka_id',Auth::user()->taluka_id)
                    ->pluck("name_of_village","id");
            
            $details_of_citizens = details_of_citizen::where('Taluka',Auth::user()->taluka_id)->paginate(10);
            return view ('list',compact('details_of_citizens','district','t','v','c'));
        }
        else
        {
            return view ('unauth');
        }
    }

    public function ListPDF()
    {
        $id = session::get('id');
        $c = DB::table('details_of_citizens')
                ->where('id', $id)
                ->get();
        $district = DB::table("districts")
                ->where('id',Auth::user()->district_id)
                ->pluck("name_of_district","id");
        $t = DB::table("talukas")
                ->where('id',Auth::user()->taluka_id)
                ->pluck("taluka_name","id");
        $v = DB::table("villages")
                ->where('taluka_id',Auth::user()->taluka_id)
                ->pluck("name_of_village","id");
            
        if(Auth::user()->role_id == '1' || Auth::user()->role_id == '2')
        {
            $details_of_citizens = DB::table('details_of_citizens')
                    ->get()
                    ->toarray();
        }
        else if(Auth::user()->role_id == '3')
        {
            $Authdist = Auth::user()->district_id;
            $details_of_citizens = DB::table('details_of_citizens')
                    ->where('details_of_citizens.District',$Authdist)
                    ->get()
                    ->toarray();
        }
        else if(Auth::user()->role_id == '4')
        {
            $AuthTaluka = Auth::user()->taluka_id;
            $details_of_citizens = DB::table('details_of_citizens')
                    ->where('details_of_citizens.Taluka',$AuthTaluka)
                    ->get()
                    ->toarray();
        }
        $title = "Details of Citizens";
        $pdf = PDF::loadView('list2',compact('details_of_citizens','district','t','v','c','title'));
        return $pdf->download('Citizens.pdf');
    }

    public function ListIncompleteEntries($Village)
    {
        if(in_array('1_2',session('access')))
        {
            if($Village=='0')
            {
                $AuthUser = Auth::user()->id;
                $id = session::get('id');
                $c = DB::table('details_of_citizens')
                        ->where('id', $id)
                        ->get();
                $district = DB::table("districts")
                        ->where('id',Auth::user()->district_id)
                        ->pluck("name_of_district","id");
                $t = DB::table("talukas")
                        ->where('id',Auth::user()->taluka_id)
                        ->pluck("taluka_name","id");
                $village = DB::table("villages")
                        ->where('taluka_id',Auth::user()->taluka_id)
                        ->get();
                $details_of_citizens =DB::select(
                        DB::raw("SELECT details_of_citizens.id,details_of_citizens.id, Full_name, date_of_birth, Mobile_no, villages.name_of_village, details_of_citizens.Village
                        FROM `details_of_citizens` 
                        join villages ON (details_of_citizens.Village = villages.id)
                        where (any_disease ='0' or Regular_check_up ='0' or are_you_handicapped ='0' or aadhar_card ='0' or aadhar_discrepancy ='0' 
                                or Voter_id ='0' or ST_pass ='0' or Govt_schemes ='0' or income_increase ='0' or tools_required ='0' 
                                or social_service ='0' or (details_of_citizens.Own_house = 'Y' and details_of_citizens.home_type is null) 
                                or (details_of_citizens.Bank_account = 'Y' and details_of_citizens.Bank_type is null)) 
                                and details_of_citizens.created_by = $AuthUser"));
            }
            else
            {
                $AuthUser = Auth::user()->id;
                $id = session::get('id');
                $c = DB::table('details_of_citizens')
                        ->where('id', $id)
                        ->get();
                $district = DB::table("districts")
                        ->where('id',Auth::user()->district_id)
                        ->pluck("name_of_district","id");
                $t = DB::table("talukas")
                        ->where('id',Auth::user()->taluka_id)
                        ->pluck("taluka_name","id");
                $village = DB::table("villages")
                        ->where('taluka_id',Auth::user()->taluka_id)
                        ->get();
                $details_of_citizens =DB::select(
                        DB::raw("SELECT details_of_citizens.id, Full_name, date_of_birth, Mobile_no, villages.name_of_village, details_of_citizens.Village
                        FROM `details_of_citizens` 
                        join villages ON (details_of_citizens.Village = villages.id)
                        where (any_disease ='0' or Regular_check_up ='0' or are_you_handicapped ='0' or aadhar_card ='0' or aadhar_discrepancy ='0' 
                                or Voter_id ='0' or ST_pass ='0' or Govt_schemes ='0' or income_increase ='0' or tools_required ='0' 
                                or social_service ='0' or (details_of_citizens.Own_house = 'Y' and details_of_citizens.home_type is null) 
                                or (details_of_citizens.Bank_account = 'Y' and details_of_citizens.Bank_type is null)) 
                                and details_of_citizens.created_by = $AuthUser
                                and villages.id = $Village"));
            }
            
            return view ('listIncomplete',compact('details_of_citizens','district','t','village','c','Village'));
        }
        else
        {
            return view ('unauth');
        }
    }

    public function delete(request $request,$id)
    {
        if(in_array('1_4',session('access')))   
        {
            $request->session()->forget('id');
            DB::delete('delete from members where Citizen_id = ?',[$id]);
            DB::delete('delete from citizen_diseases where Citizen_id = ?',[$id]);
            DB::delete('delete from citizen_handicaps where Citizen_id = ?',[$id]);
            DB::delete('delete from citizen_govt_schemes where Citizen_id = ?',[$id]);
            DB::delete('delete from citizen_work_types where Citizen_id = ?',[$id]);
            DB::delete('delete from citizen_tools where Citizen_id = ?',[$id]);
            DB::delete('delete from citizen_medical_equipments where Citizen_id = ?',[$id]);
            DB::delete('delete from citizen_social_services where Citizen_id = ?',[$id]);
            DB::delete('delete from citizen_teaching_skills where Citizen_id = ?',[$id]);
            DB::delete('delete from citizen_hobbies where Citizen_id = ?',[$id]);
            $details_of_citizens = details_of_citizen::find($id);
            $details_of_citizens->delete();
            $id_1 = session::get('id');
            $c = DB::table('details_of_citizens')
                    ->where('id', $id_1)
                    ->get();
            $district = DB::table("districts")
                    ->where('id',Auth::user()->district_id)
                    ->pluck("name_of_district","id");
            $t = DB::table("talukas")
                    ->where('id',Auth::user()->taluka_id)
                    ->pluck("taluka_name","id");
            $v = DB::table("villages")
                    ->where('taluka_id',Auth::user()->taluka_id)
                    ->pluck("name_of_village","id");
            
            $details_of_citizens = details_of_citizen::where('Taluka',Auth::user()->taluka_id)->paginate(10);
            return view ('listcitizens',compact('details_of_citizens','district','t','v','c'));
        }
        else
        {
            return view('unauth');
        }
    }

    public function search(Request $request)
    {
        $details_of_citizens = DB::table('details_of_citizens')
                    ->select('id','Full_name','date_of_birth','Mobile_no')
                    ->where('id', $request->searchReferenceNo)
                    ->where('Taluka',Auth::user()->taluka_id)
                    ->paginate(5);
        return view ('Listcitizens',compact('details_of_citizens'));
    }

    public function search_incomplete(Request $request)
    {
        $AuthUser = Auth::user()->id;
        $ID = $request->searchReferenceNo;
        $Taluka = Auth::user()->taluka_id;
        $details_of_citizens =DB::select(
                    DB::raw("select details_of_citizens.id, Full_name, date_of_birth, Mobile_no, villages.name_of_village
                            from details_of_citizens 
                            join villages ON (details_of_citizens.Village = villages.id)
                            where details_of_citizens.id = $ID and 
                            Taluka = $Taluka and 
                            created_by = $AuthUser and 
                            (any_disease ='0' or Regular_check_up ='0' or are_you_handicapped ='0' or aadhar_card ='0' 
                            or aadhar_discrepancy ='0' or Voter_id ='0' or ST_pass ='0' or Govt_schemes ='0' 
                            or income_increase ='0' or tools_required ='0' or social_service ='0')"));
        return view ('Incomplete_citizens',compact('details_of_citizens'));                        
    }

    public function VillageWise_Incomplete_Entries(Request $request,$Village)
    {
        $AuthUser = Auth::user()->id;
        $ID = $request->searchReferenceNo;
        $Taluka = Auth::user()->taluka_id;
        if($Village>0)
        {
            $details_of_citizens =DB::select(
                    DB::raw("select details_of_citizens.id, Full_name, date_of_birth, Mobile_no, villages.name_of_village
                            from details_of_citizens 
                            join villages ON (details_of_citizens.Village = villages.id)
                            where Village = $Village
                            and created_by = $AuthUser 
                            and (any_disease ='0' or Regular_check_up ='0' or are_you_handicapped ='0' or aadhar_card ='0' 
                            or aadhar_discrepancy ='0' or Voter_id ='0' or ST_pass ='0' or Govt_schemes ='0' 
                            or income_increase ='0' or tools_required ='0' or social_service ='0')"));
        }
        if($Village == '0')
        {   
            $details_of_citizens =DB::select(
                    DB::raw("select details_of_citizens.id, Full_name, date_of_birth, Mobile_no, villages.name_of_village
                            from details_of_citizens 
                            join villages ON (details_of_citizens.Village = villages.id)
                            where Taluka = $Taluka and 
                            created_by = $AuthUser and 
                            (any_disease ='0' or Regular_check_up ='0' or are_you_handicapped ='0' or aadhar_card ='0' 
                            or aadhar_discrepancy ='0' or Voter_id ='0' or ST_pass ='0' or Govt_schemes ='0' 
                            or income_increase ='0' or tools_required ='0' or social_service ='0')"));
        }
        return view ('Incomplete_citizens',compact('details_of_citizens'));
    }

    public function exportExcel()
    {
        return Excel::download(new CitizenExport,'List_of_Citizens.xlsx');
    }

    public function ExportCSV()
    {
        return Excel::download(new CitizenExport,'List_of_Citizens.csv');
    }
}