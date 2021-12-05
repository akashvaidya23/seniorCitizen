<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class details_of_citizen extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable = [
        'id',
        'Full_name',
        'date_of_birth', 
        'Education',
        'Complete_address',
        'District',
        'Taluka',
        'Village',
        'Mobile_no',
        'Income_source',
        'Own_house',
        'home_type',
        'Water_closet',
        'Bathroom',
        'stove_type',
        'Land_ownership',
        'Land_dispute',
        'Bank_account',
        'Bank_type',
        'any_disease',
        'Hospital_type',
        'Regular_check_up',
        'are_you_handicapped',
        'daily_chores',
        'aadhar_card',
        'aadhar_discrepancy',
        'Voter_id',
        'Ration_card',
        'ST_pass',
        'Govt_schemes',
        'income_increase',
        'tools_required',
        'social_service',
        'any_comment',
        'any_difficulties',
        'designated_officer_name',
        'designated_officer_contact_no',
        'created_at',
        'created_by',
        'Last_updated_at',
        'Last_updated_by',
        'Page_count',
    ];

    public static function getCitizens()
    {
        if(Auth::user()->role_id == '1' || Auth::user()->role_id == '2')
        {
            $records = DB::table('details_of_citizens')
                    ->select('id','Full_name','date_of_birth','Education','Complete_address','District','Taluka','Village','Mobile_no','Income_source',
                            'Own_house','home_type','Water_closet','Bathroom','stove_type','Land_ownership','Land_dispute','Bank_account','Bank_type',
                            'any_disease','Hospital_type','Regular_check_up','are_you_handicapped','daily_chores','aadhar_card','aadhar_discrepancy',
                            'Voter_id','Ration_card','ST_pass','Govt_schemes','income_increase','tools_required','social_service','any_comment','any_difficulties',
                            'designated_officer_name','designated_officer_contact_no','created_at','created_by','Last_updated_at','Last_updated_by')
                    ->get()
                    ->toarray();
        }
        else if(Auth::user()->role_id == '3')
        {
            $Authdist = Auth::user()->district_id;
            $records = DB::table('details_of_citizens')
                    ->select('id','Full_name','date_of_birth','Education','Complete_address','District','Taluka','Village','Mobile_no','Income_source',
                            'Own_house','home_type','Water_closet','Bathroom','stove_type','Land_ownership','Land_dispute','Bank_account','Bank_type',
                            'any_disease','Hospital_type','Regular_check_up','are_you_handicapped','daily_chores','aadhar_card','aadhar_discrepancy',
                            'Voter_id','Ration_card','ST_pass','Govt_schemes','income_increase','tools_required','social_service','any_comment','any_difficulties',
                            'designated_officer_name','designated_officer_contact_no','created_at','created_by','Last_updated_at','Last_updated_by')
                    ->where('details_of_citizens.District',$Authdist)
                    ->get()
                    ->toarray();
        }
        else if(Auth::user()->role_id == '4')
        {
            $AuthTaluka = Auth::user()->taluka_id;
            $records = DB::table('details_of_citizens')
                    ->select('id','Full_name','date_of_birth','Education','Complete_address','District','Taluka','Village','Mobile_no','Income_source',
                            'Own_house','home_type','Water_closet','Bathroom','stove_type','Land_ownership','Land_dispute','Bank_account','Bank_type',
                            'any_disease','Hospital_type','Regular_check_up','are_you_handicapped','daily_chores','aadhar_card','aadhar_discrepancy',
                            'Voter_id','Ration_card','ST_pass','Govt_schemes','income_increase','tools_required','social_service','any_comment','any_difficulties',
                            'designated_officer_name','designated_officer_contact_no','created_at','created_by','Last_updated_at','Last_updated_by')
                    ->where('details_of_citizens.Taluka',$AuthTaluka)
                    ->get()
                    ->toarray();
        }
        return $records;
    }
}
