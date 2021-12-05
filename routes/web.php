<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CitizenController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () 
{
    return view('auth.login');
});

    //Route::get('redirects',[App\Http\Controllers\HomeController::class,'index']);

    Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () 
    {
        return view('dashboard');
    })->name('dashboard');

    Route::middleware(['auth', 'isUser'])->get('/dashboard', function () 
    {
        return view('dashboard');
    })->name('dashboard');

    Route::get('citizen/tab1/{id}',[App\Http\Controllers\CitizenController::class,'tab1'])->name('tab1');

    Route::post('/citizen/tab1/insert',[App\Http\Controllers\CitizenController::class,'insertTab1'])->name('tab1Insert');

    Route::get('citizen/tab2',[App\Http\Controllers\CitizenController::class,'tab2'])->name('tab2'); 

    Route::post('/citizen/tab2/insert',[App\Http\Controllers\CitizenController::class,'insertTab2'])->name('tab2Insert');
    
    Route::post('/tab2/insert',[App\Http\Controllers\CitizenController::class,'CountTab2']);

    Route::get('citizen/tab3',[App\Http\Controllers\CitizenController::class,'tab3'])->name('tab3');

    Route::post('/citizen/tab3/insert',[App\Http\Controllers\CitizenController::class,'insertTab3'])->name('tab3Insert'); 

    Route::get('citizen/tab4',[App\Http\Controllers\CitizenController::class,'tab4'])->name('tab4');

    Route::post('/citizen/tab4/insert',[App\Http\Controllers\CitizenController::class,'insertTab4'])->name('tab4Insert'); 

    Route::get('citizen/tab5',[App\Http\Controllers\CitizenController::class,'tab5'])->name('tab5');

    Route::post('/citizen/tab5/insert',[App\Http\Controllers\CitizenController::class,'insertTab5'])->name('tab5Insert'); 

    Route::get('citizen/tab6',[App\Http\Controllers\CitizenController::class,'tab6'])->name('tab6');

    Route::post('/citizen/tab6/insert',[App\Http\Controllers\CitizenController::class,'insertTab6'])->name('tab6Insert'); 

    Route::get('district',[App\Http\Controllers\CitizenController::class,'district']);

    Route::get('myform/ajax/{id}',[App\Http\Controllers\CitizenController::class,'myformAjax']);

    Route::get('myform/myVillage/{id}',[App\Http\Controllers\CitizenController::class,'myVillage']);

    Route::get('/all',[App\Http\Controllers\CitizenController::class,'list'])->name('List');

    Route::get('/all/Incomplete/{village}',[App\Http\Controllers\CitizenController::class,'ListIncompleteEntries'])->name('ListIncompleteEntries');

    Route::post('/update/tab1/{id}',[App\Http\Controllers\CitizenController::class,'updateTab1'])->name('updateTable1');

    Route::get('/delete/{id}',[App\Http\Controllers\CitizenController::class,'delete'])->name('delete');

    Route::get('/delete/member/{id}',[App\Http\Controllers\CitizenController::class,'deleteMember'])->name('deleteMember');

    Route::post('/search',[App\Http\Controllers\CitizenController::class,'search'])->name('search');

    Route::post('/search/incomplete',[App\Http\Controllers\CitizenController::class,'search_incomplete'])->name('search_incomplete');

    Route::get('/Incomplete_Entries',[App\Http\Controllers\DivisionalController::class,'Incomplete_Entries'])->name('Incomplete_Entries');

    Route::post('/search/incompleteRecords/{Village}',[App\Http\Controllers\CitizenController::class,'VillageWise_Incomplete_Entries'])->name('VillageWise_Incomplete_Entries');

    Route::get('export/excel',[App\Http\Controllers\CitizenController::class,'exportExcel'])->name('exportExcel');

    Route::get('export/csv',[App\Http\Controllers\CitizenController::class,'ExportCSV'])->name('ExportCSV');

    Route::get('get/pdf',[App\Http\Controllers\CitizenController::class,'ListPDF'])->name('ListPDF');

    Route::get("/page", function()
    {
        return View("list2");
    });






    Route::get('/create/user',[App\Http\Controllers\AdminController::class,'index'])->name('CreateUser');

    Route::get('/List/user',[App\Http\Controllers\AdminController::class,'show'])->name('ListUser');

    Route::get('/Edit/user/{id}',[App\Http\Controllers\AdminController::class,'edit'])->name('EditUser');

    Route::post('/Update/user/{id}',[App\Http\Controllers\AdminController::class,'Update'])->name('EditUser');

    Route::post('/insert/user',[App\Http\Controllers\AdminController::class,'create'])->name('InsertUser');

    Route::get('/change/password/{id}',[App\Http\Controllers\AdminController::class,'password'])->name('PasswordView');

    Route::post('/insert/Password/{id}',[App\Http\Controllers\AdminController::class,'InsertNewPassword'])->name('InsertNewPassword');



    Route::get('/dashboard/access', [App\Http\Controllers\AccessController::class,'index'])->name('dashboardAccess');

    Route::post('/dashboard/access',[App\Http\Controllers\AccessController::class,'create'])->name('dashboardAccess');

    Route::get('/Access/getRoleACL/{id}',[App\Http\Controllers\AccessController::class,'getRoleACL'])->name('');



    Route::get('/redirects', [App\Http\Controllers\DivisionalController::class,'index'])->name('Divisional_Dashboard');

    Route::get('/district/count/{id}', [App\Http\Controllers\DivisionalController::class,'district_count']);//->name('Divisional_Dashboard');

    Route::get('/village/count/{id}/{district_id}', [App\Http\Controllers\DivisionalController::class,'taluka_count']);//->name('Divisional_Dashboard');

    Route::get('/Reports/tab1', [App\Http\Controllers\DivisionalController::class,'Reports_tab1'])->name('ReportsTab1');

    Route::get('/Reports/tab2', [App\Http\Controllers\DivisionalController::class,'Reports_tab2'])->name('ReportsTab2');

    Route::get('/Reports/tab3', [App\Http\Controllers\DivisionalController::class,'Reports_tab3'])->name('ReportsTab3');

    Route::get('/Reports/tab4', [App\Http\Controllers\DivisionalController::class,'Reports_tab4'])->name('ReportsTab4');

    Route::get('/Reports/tab5', [App\Http\Controllers\DivisionalController::class,'Reports_tab5'])->name('ReportsTab5');

    Route::get('/Reports/tab6', [App\Http\Controllers\DivisionalController::class,'Reports_tab6'])->name('ReportsTab6');

    Route::get('/UserWiseEntries', [App\Http\Controllers\DivisionalController::class,'UserWiseEntries'])->name('UserWiseEntries');

    Route::get('/Entries/District/{districtID}', [App\Http\Controllers\DivisionalController::class,'DistrictUserWise']);

    Route::get('/education/count', [App\Http\Controllers\DivisionalController::class,'EducationCount'])->name('EducationCount');

    Route::get('ReportTab1/Educationwise', [App\Http\Controllers\DivisionalController::class,'EducationWise'])->name('EducationWise');

    Route::get('village/Educationwise/{talukaID}', [App\Http\Controllers\DivisionalController::class,'Village_wise_Education'])->name('Village_wise_Education');

    Route::get('village/education/{talukaID}/{DistrictID}', [App\Http\Controllers\DivisionalController::class,'Taluka_education'])->name('Village_wise_Education');

    Route::get('Taluka/education/{districtID}', [App\Http\Controllers\DivisionalController::class,'district_wise_education']);//->name('Village_wise_Education');

    Route::get('Taluka/OwnHouseYN/{districtID}', [App\Http\Controllers\DivisionalController::class,'Taluka_OwnHouseYN']);//->name('Village_wise_Education');

    Route::get('ReportTab1/OwnHouseYN', [App\Http\Controllers\DivisionalController::class,'OwnHouseYN'])->name('OwnHouseYN');

    Route::get('VillageWise/OwnHouseYN/{Taluka_id}', [App\Http\Controllers\DivisionalController::class,'Village_OwnHouseYN']);//->name('OwnHouseYN');

    Route::get('Village/Home_type_wise/{Taluka_id}', [App\Http\Controllers\DivisionalController::class,'Village_Home_type_wise']);//->name('OwnHouseYN');

    Route::get('village/Own_HouseYN/{talukaID}/{DistrictID}', [App\Http\Controllers\DivisionalController::class,'District_OwnHouseYN']);

    Route::get('ReportTab1/Home_type_wise', [App\Http\Controllers\DivisionalController::class,'Home_type_wise'])->name('Home_type_wise');

    Route::get('Taluka/Home_type_wise/{DistrictID}', [App\Http\Controllers\DivisionalController::class,'Taluka_Home_Type_Wise']);//->name('Home_type_wise');

    Route::get('village/Home_types/{talukaID}/{DistrictID}', [App\Http\Controllers\DivisionalController::class,'District_Home_type_wise']);

    Route::get('ReportTab1/Stove_type_wise', [App\Http\Controllers\DivisionalController::class,'Stove_type_wise'])->name('Stove_type_wise');

    Route::get('Taluka/Stove_type_wise/{DistrictID}',[App\Http\Controllers\DivisionalController::class,'Taluka_stove_type_wise']);

    Route::get('Village/Stove_type_wise/{talukaID}',[App\Http\Controllers\DivisionalController::class,'Village_stove_type_wise']);

    Route::get('ReportTab1/Income_source_wise', [App\Http\Controllers\DivisionalController::class,'Income_source_wise'])->name('Income_source_wise');

    Route::get('Taluka/Income_source_wise/{DistrictID}', [App\Http\Controllers\DivisionalController::class,'Taluka_Income_source_wise']);//->name('Income_source_wise');

    Route::get('Village/Income_source_wise/{talukaID}', [App\Http\Controllers\DivisionalController::class,'Village_Income_source_wise']);

    Route::get('ReportTab1/Bank_YN', [App\Http\Controllers\DivisionalController::class,'Bank_YN'])->name('Bank_YN');

    Route::get('Taluka/Bank_YN/{DistrictID}', [App\Http\Controllers\DivisionalController::class,'Taluka_Bank_YN']);

    Route::get('Village/Bank_YN/{talukaID}', [App\Http\Controllers\DivisionalController::class,'Village_Bank_YN']);

    Route::get('ReportTab1/Bank_type_wise', [App\Http\Controllers\DivisionalController::class,'Bank_type_wise'])->name('Bank_type_wise');

    Route::get('Taluka/BankTypeWise/{DistrictID}', [App\Http\Controllers\DivisionalController::class,'Taluka_Bank_type_wise'])->name('Taluka_Bank_type_wise');

    Route::get('Village/BankTypeWise/{talukaID}', [App\Http\Controllers\DivisionalController::class,'Village_Bank_type_wise'])->name('Village_Bank_type_wise');
    
    Route::get('ReportTab1/WashroomWise', [App\Http\Controllers\DivisionalController::class,'WashroomWise'])->name('WashroomWise');

    Route::get('Taluka/WashroomWise/{DistrictID}', [App\Http\Controllers\DivisionalController::class,'Taluka_WashroomWise'])->name('Taluka_WashroomWise');

    Route::get('Village/WashroomWise/{talukaID}', [App\Http\Controllers\DivisionalController::class,'Village_WashroomWise'])->name('Village_WashroomWise');

    Route::get('ReportTab1/Bathroomwise', [App\Http\Controllers\DivisionalController::class,'Bathroomwise'])->name('Bathroomwise');

    Route::get('Taluka/BathroomWise/{DistrictID}', [App\Http\Controllers\DivisionalController::class,'Taluka_Bathroomwise'])->name('Taluka_Bathroomwise');

    Route::get('Village/BathroomWise/{talukaID}', [App\Http\Controllers\DivisionalController::class,'Village_Bathroomwise'])->name('Village_Bathroomwise');

    Route::get('ReportTab1/LandWise', [App\Http\Controllers\DivisionalController::class,'LandWise'])->name('LandWise');

    Route::get('Taluka/LandWise/{DistrictID}', [App\Http\Controllers\DivisionalController::class,'Taluka_LandWise'])->name('Taluka_LandWise');

    Route::get('Village/LandWise/{talukaID}', [App\Http\Controllers\DivisionalController::class,'Village_LandWise'])->name('Village_LandWise');

    Route::get('ReportTab1/Land_Dispute', [App\Http\Controllers\DivisionalController::class,'Land_Dispute'])->name('Land_Dispute');

    Route::get('Taluka/LandDisputeWise/{DistrictID}', [App\Http\Controllers\DivisionalController::class,'Taluka_Land_Dispute'])->name('Taluka_Land_Dispute');

    Route::get('Village/LandDisputeWise/{talukaID}', [App\Http\Controllers\DivisionalController::class,'Village_Land_Dispute'])->name('Village_Land_Dispute');

    Route::get('ReportTab2/Member', [App\Http\Controllers\DivisionalController::class,'Member'])->name('Member');

    Route::get('Taluka/MemberWise/{DistrictID}', [App\Http\Controllers\DivisionalController::class,'Taluka_Member'])->name('Taluka_Member');

    Route::get('village/MemberWise/{talukaID}', [App\Http\Controllers\DivisionalController::class,'Village_Member'])->name('Village_Member');

    Route::get('ReportTab3/Regular_CheckUp', [App\Http\Controllers\DivisionalController::class,'Regular_CheckUp'])->name('Regular_CheckUp');

    Route::get('Taluka/CheckupWise/{DistrictID}', [App\Http\Controllers\DivisionalController::class,'Taluka_Regular_CheckUp'])->name('Taluka_Regular_CheckUp');

    Route::get('village/CheckupWise/{talukaID}', [App\Http\Controllers\DivisionalController::class,'Village_Regular_CheckUp'])->name('Village_Regular_CheckUp');

    Route::get('ReportTab3/DiseaseYN', [App\Http\Controllers\DivisionalController::class,'DiseaseYN'])->name('DiseaseYN');

    Route::get('Taluka/disease_YN/{DistrictID}', [App\Http\Controllers\DivisionalController::class,'Taluka_DiseaseYN'])->name('Taluka_DiseaseYN');

    Route::get('village/disease_YN/{talukaID}', [App\Http\Controllers\DivisionalController::class,'Village_DiseaseYN'])->name('Village_DiseaseYN');

    Route::get('ReportTab3/DiseaseWise', [App\Http\Controllers\DivisionalController::class,'DiseaseWise'])->name('DiseaseWise');

    Route::get('Taluka/diseaseWise/{DistrictID}', [App\Http\Controllers\DivisionalController::class,'Taluka_DiseaseWise'])->name('Taluka_DiseaseWise');

    Route::get('village/diseaseWise/{talukaID}', [App\Http\Controllers\DivisionalController::class,'Village_DiseaseWise'])->name('Village_DiseaseWise');

    Route::get('ReportTab3/Hospital_type_wise', [App\Http\Controllers\DivisionalController::class,'Hospital_type_wise'])->name('Hospital_type_wise');

    Route::get('Taluka/Hospital_type_wise/{DistrictID}', [App\Http\Controllers\DivisionalController::class,'Taluka_Hospital_type_wise'])->name('Taluka_Hospital_type_wise');

    Route::get('village/Hospital_type_wise/{talukaID}', [App\Http\Controllers\DivisionalController::class,'Village_Hospital_type_wise'])->name('Village_Hospital_type_wise');

    Route::get('ReportTab3/Handicap_YN', [App\Http\Controllers\DivisionalController::class,'Handicap_YN'])->name('Handicap_YN');

    Route::get('Taluka/Handicap_YN/{DistrictID}', [App\Http\Controllers\DivisionalController::class,'Taluka_Handicap_YN'])->name('Taluka_Handicap_YN');

    Route::get('village/Handicap_YN/{talukaID}', [App\Http\Controllers\DivisionalController::class,'Village_Handicap_YN'])->name('Village_Handicap_YN');

    Route::get('ReportTab3/Handicap_wise', [App\Http\Controllers\DivisionalController::class,'Handicap_wise'])->name('Handicap_wise');

    Route::get('Taluka/Handicap_wise/{DistrictID}', [App\Http\Controllers\DivisionalController::class,'Taluka_Handicap_wise'])->name('Taluka_Handicap_wise');

    Route::get('village/Handicap_wise/{talukaID}', [App\Http\Controllers\DivisionalController::class,'Village_Handicap_wise'])->name('Village_Handicap_wise');

    Route::get('ReportTab3/Chores_wise', [App\Http\Controllers\DivisionalController::class,'Chores_wise'])->name('Chores_wise');

    Route::get('Taluka/Chores_wise/{DistrictID}', [App\Http\Controllers\DivisionalController::class,'Taluka_Chores_wise'])->name('Taluka_Chores_wise');

    Route::get('village/Chores_wise/{talukaID}', [App\Http\Controllers\DivisionalController::class,'Village_Chores_wise'])->name('Village_Chores_wise');

    Route::get('ReportTab4/RationCardYN', [App\Http\Controllers\DivisionalController::class,'RationCardYN'])->name('RationCardYN');

    Route::get('Taluka/RationCardYN/{DistrictID}', [App\Http\Controllers\DivisionalController::class,'Taluka_RationCardYN'])->name('Taluka_RationCardYN');

    Route::get('village/RationCardYN/{talukaID}', [App\Http\Controllers\DivisionalController::class,'Village_RationCardYN'])->name('Village_RationCardYN');

    Route::get('ReportTab4/RationCard_Type_Wise', [App\Http\Controllers\DivisionalController::class,'RationCard_Type_Wise'])->name('RationCard_Type_Wise');

    Route::get('Taluka/RationCard/{DistrictID}', [App\Http\Controllers\DivisionalController::class,'Taluka_RationCard_Type_Wise'])->name('Taluka_RationCard_Type_Wise');

    Route::get('village/RationCard/{talukaID}', [App\Http\Controllers\DivisionalController::class,'Village_RationCard_Type_Wise'])->name('Village_RationCard_Type_Wise');

    Route::get('ReportTab4/Aadhar', [App\Http\Controllers\DivisionalController::class,'AadharWise'])->name('AadharWise');

    Route::get('Taluka/AadharWise/{DistrictID}', [App\Http\Controllers\DivisionalController::class,'Taluka_AadharWise'])->name('Taluka_AadharWise');

    Route::get('village/AadharWise/{talukaID}', [App\Http\Controllers\DivisionalController::class,'Village_AadharWise'])->name('Village_AadharWise');

    Route::get('ReportTab4/AadharDiscrepancy', [App\Http\Controllers\DivisionalController::class,'AadharDiscrepancy'])->name('AadharDiscrepancy');

    Route::get('Taluka/AadharDiscrepancyWise/{DistrictID}', [App\Http\Controllers\DivisionalController::class,'Taluka_AadharDiscrepancy'])->name('Taluka_AadharDiscrepancy');

    Route::get('village/AadharDiscrepancyWise/{talukaID}', [App\Http\Controllers\DivisionalController::class,'Village_AadharDiscrepancy'])->name('Village_AadharDiscrepancy');

    Route::get('ReportTab4/VoterID', [App\Http\Controllers\DivisionalController::class,'VoterID'])->name('VoterID');

    Route::get('Taluka/VoterIDWise/{DistrictID}', [App\Http\Controllers\DivisionalController::class,'Taluka_VoterID'])->name('Taluka_VoterID');

    Route::get('village/VoterIDWise/{talukaID}', [App\Http\Controllers\DivisionalController::class,'Village_VoterID'])->name('Village_VoterID');

    Route::get('ReportTab4/STPass', [App\Http\Controllers\DivisionalController::class,'STPass'])->name('STPass');

    Route::get('Taluka/STPassWise/{DistrictID}', [App\Http\Controllers\DivisionalController::class,'Taluka_STPass'])->name('Taluka_STPass');

    Route::get('village/STPassWise/{talukaID}', [App\Http\Controllers\DivisionalController::class,'Village_STPass'])->name('Village_STPass');

    Route::get('ReportTab5/SchemeYN', [App\Http\Controllers\DivisionalController::class,'SchemeYN'])->name('SchemeYN');

    Route::get('Taluka/SchemeAvail/{DistrictID}', [App\Http\Controllers\DivisionalController::class,'Taluka_SchemeYN'])->name('Taluka_SchemeYN');

    Route::get('village/SchemeAvail/{talukaID}', [App\Http\Controllers\DivisionalController::class,'Village_SchemeYN'])->name('Village_SchemeYN');

    Route::get('ReportTab5/Govt_Scheme_Wise', [App\Http\Controllers\DivisionalController::class,'Govt_Scheme_Wise'])->name('Govt_Scheme_Wise');

    Route::get('Taluka/Govt_SchemeWise/{DistrictID}', [App\Http\Controllers\DivisionalController::class,'Taluka_Govt_Scheme_Wise'])->name('Taluka_Govt_Scheme_Wise');

    Route::get('village/Govt_SchemeWise/{talukaID}', [App\Http\Controllers\DivisionalController::class,'village_Govt_Scheme_Wise'])->name('village_Govt_Scheme_Wise');

    Route::get('ReportTab6/Income_Increase_YN', [App\Http\Controllers\DivisionalController::class,'Income_Increase_YN'])->name('Income_Increase_YN');

    Route::get('Taluka/Income_increase_YN/{DistrictID}', [App\Http\Controllers\DivisionalController::class,'Taluka_Income_Increase_YN'])->name('Taluka_Income_Increase_YN');

    Route::get('village/Income_increase_YN/{talukaID}', [App\Http\Controllers\DivisionalController::class,'Village_Income_Increase_YN'])->name('Village_Income_Increase_YN');

    Route::get('ReportTab6/Income_Increase_Wise', [App\Http\Controllers\DivisionalController::class,'Income_Increase_Wise'])->name('Income_Increase_Wise');

    Route::get('Taluka/income_increaseWise/{DistrictID}', [App\Http\Controllers\DivisionalController::class,'Taluka_Income_Increase_Wise'])->name('Taluka_Income_Increase_Wise');

    Route::get('village/income_increaseWise/{talukaID}', [App\Http\Controllers\DivisionalController::class,'Village_Income_Increase_Wise'])->name('Village_Income_Increase_Wise');

    Route::get('ReportTab6/Tool_YN', [App\Http\Controllers\DivisionalController::class,'Tool_YN'])->name('Tool_YN');

    Route::get('Taluka/Tools_YN/{DistrictID}', [App\Http\Controllers\DivisionalController::class,'Taluka_Tool_YN'])->name('Taluka_Tool_YN');

    Route::get('village/Tools_YN/{talukaID}', [App\Http\Controllers\DivisionalController::class,'Village_Tool_YN'])->name('Village_Tool_YN');

    Route::get('ReportTab6/Tool_wise', [App\Http\Controllers\DivisionalController::class,'Tool_wise'])->name('Tool_wise');

    Route::get('Taluka/ToolWise/{DistrictID}', [App\Http\Controllers\DivisionalController::class,'Taluka_Tool_wise'])->name('Taluka_Tool_wise');

    Route::get('village/ToolWise/{talukaID}', [App\Http\Controllers\DivisionalController::class,'Village_Tool_wise'])->name('Village_Tool_wise');

    Route::get('ReportTab6/medical_equipment', [App\Http\Controllers\DivisionalController::class,'medical_equipment'])->name('medical_equipment');

    Route::get('Taluka/Medical_Equipment_Wise/{DistrictID}', [App\Http\Controllers\DivisionalController::class,'Taluka_medical_equipment'])->name('Taluka_medical_equipment');

    Route::get('village/Medical_Equipment_Wise/{talukaID}', [App\Http\Controllers\DivisionalController::class,'Village_medical_equipment'])->name('Village_medical_equipment');

    Route::get('ReportTab6/Social_service_YN', [App\Http\Controllers\DivisionalController::class,'Social_service_YN'])->name('Social_service_YN');

    Route::get('Taluka/Social_service_YN/{DistrictID}', [App\Http\Controllers\DivisionalController::class,'Taluka_Social_service_YN'])->name('Taluka_Social_service_YN');

    Route::get('village/Social_service_YN/{talukaID}', [App\Http\Controllers\DivisionalController::class,'Village_Social_service_YN'])->name('Village_Social_service_YN');

    Route::get('ReportTab6/Social_service_wise', [App\Http\Controllers\DivisionalController::class,'Social_service_wise'])->name('Social_service_wise');

    Route::get('Taluka/Social_service_Wise/{DistrictID}', [App\Http\Controllers\DivisionalController::class,'Taluka_Social_service_wise'])->name('Taluka_Social_service_wise');

    Route::get('village/Social_service_Wise/{talukaID}', [App\Http\Controllers\DivisionalController::class,'Village_Social_service_wise'])->name('Village_Social_service_wise');

    Route::get('ReportTab6/Teaching_skill_Wise', [App\Http\Controllers\DivisionalController::class,'Teaching_skill_Wise'])->name('Teaching_skill_Wise');

    Route::get('Taluka/Teaching_skill_Wise/{DistrictID}', [App\Http\Controllers\DivisionalController::class,'Taluka_Teaching_skill_Wise'])->name('Taluka_Teaching_skill_Wise');

    Route::get('village/Teaching_skill_Wise/{talukaID}', [App\Http\Controllers\DivisionalController::class,'village_Teaching_skill_Wise'])->name('village_Teaching_skill_Wise');

    Route::get('ReportTab6/Hobby_wise', [App\Http\Controllers\DivisionalController::class,'Hobby_wise'])->name('Hobby_wise');

    Route::get('Taluka/Hobby_Wise/{DistrictID}', [App\Http\Controllers\DivisionalController::class,'Taluka_Hobby_wise'])->name('Taluka_Hobby_wise');

    Route::get('village/Hobby_Wise/{talukaID}', [App\Http\Controllers\DivisionalController::class,'Village_Hobby_wise'])->name('Village_Hobby_wise');




    Route::get('/create/action',[App\Http\Controllers\ActionController::class,'index'])->name('CreateAction');
    Route::post('/insert/action',[App\Http\Controllers\ActionController::class,'create'])->name('InsertAction');

    Route::get('/create/bank',[App\Http\Controllers\Bank_typeController::class,'index'])->name('CreateBank');
    Route::post('/insert/bank',[App\Http\Controllers\Bank_typeController::class,'insert'])->name('InsertBank');

    Route::get('/create/disease',[App\Http\Controllers\DiseaseController::class,'index'])->name('CreateDisease');
    Route::post('/insert/disease',[App\Http\Controllers\DiseaseController::class,'insert'])->name('InsertDisease');

    Route::get('/create/scheme',[App\Http\Controllers\govt_schemeController::class,'index'])->name('CreateScheme');
    Route::post('/insert/scheme',[App\Http\Controllers\govt_schemeController::class,'insert'])->name('InsertScheme');

    Route::get('/create/HandicapType',[App\Http\Controllers\HandicapController::class,'index'])->name('CreateHandicapType');
    Route::post('/insert/HandicapType',[App\Http\Controllers\HandicapController::class,'insert'])->name('InsertHandicapType');

    Route::get('/create/HelpType',[App\Http\Controllers\help_typeController::class,'index'])->name('CreateHelpType');
    Route::post('/insert/HelpType',[App\Http\Controllers\help_typeController::class,'insert'])->name('InsertHelpType');

    Route::get('/create/hobby',[App\Http\Controllers\HobbyController::class,'index'])->name('CreateHobby');
    Route::post('/insert/hobby',[App\Http\Controllers\HobbyController::class,'insert'])->name('InsertHobby');

    Route::get('/create/home',[App\Http\Controllers\home_typeController::class,'index'])->name('Createhome');
    Route::post('/insert/home',[App\Http\Controllers\home_typeController::class,'insert'])->name('Inserthome');

    Route::get('/create/hospital',[App\Http\Controllers\hospital_typeController::class,'index'])->name('CreateHospital');
    Route::post('/insert/hospital',[App\Http\Controllers\hospital_typeController::class,'insert'])->name('InsertHospital');

    Route::get('/create/income',[App\Http\Controllers\Income_sourceController::class,'index'])->name('CreateIncome');
    Route::post('/insert/income',[App\Http\Controllers\Income_sourceController::class,'insert'])->name('InsertIncome');

    Route::get('/create/equipment',[App\Http\Controllers\Medical_Equipment_controller::class,'index'])->name('CreateEquipment');
    Route::post('/insert/equipment',[App\Http\Controllers\Medical_Equipment_controller::class,'insert'])->name('InsertEquipment');

    Route::get('/create/page',[App\Http\Controllers\PageController::class,'index'])->name('CreatePage');
    Route::post('/insert/page',[App\Http\Controllers\PageController::class,'insert'])->name('InsertPage');

    Route::get('/create/relation',[App\Http\Controllers\RelationController::class,'index'])->name('CreateRelation');
    Route::post('/insert/relation',[App\Http\Controllers\RelationController::class,'insert'])->name('InsertRelation');

    Route::get('/create/role',[App\Http\Controllers\RoleController::class,'index'])->name('CreateRole');
    Route::post('/insert/role',[App\Http\Controllers\RoleController::class,'insert'])->name('InsertRole');

    Route::get('/create/social',[App\Http\Controllers\social_service_types_Controller::class,'index'])->name('CreateSocial');
    Route::post('/insert/social',[App\Http\Controllers\social_service_types_Controller::class,'insert'])->name('InsertSocial');

    Route::get('/create/stove',[App\Http\Controllers\stove_type_Controller::class,'index'])->name('CreateStove');
    Route::post('/insert/stove',[App\Http\Controllers\stove_type_Controller::class,'insert'])->name('InsertStove');

    Route::get('/create/teaching',[App\Http\Controllers\teaching_skills_Controller::class,'index'])->name('CreateTeaching');
    Route::post('/insert/teaching',[App\Http\Controllers\teaching_skills_Controller::class,'insert'])->name('InsertTeaching');

    Route::get('/create/tool',[App\Http\Controllers\tool_type_controller::class,'index'])->name('CreateTool');
    Route::post('/insert/tool',[App\Http\Controllers\tool_type_controller::class,'insert'])->name('InsertTool');

    Route::get('/create/work',[App\Http\Controllers\work_type_controller::class,'index'])->name('CreateWork');
    Route::post('/insert/work',[App\Http\Controllers\work_type_controller::class,'insert'])->name('InsertWork');

    Route::get('/create/degree',[App\Http\Controllers\EducationController::class,'index'])->name('CreateDegree');
    Route::post('/insert/degree',[App\Http\Controllers\EducationController::class,'insert'])->name('InsertDegree');

    Route::get('/create/ration',[App\Http\Controllers\RationCardController::class,'index'])->name('CreateRation');
    Route::post('/insert/ration',[App\Http\Controllers\RationCardController::class,'insert'])->name('InsertRation');

    Route::get('/create/district',[App\Http\Controllers\DistrictController::class,'index'])->name('CreateDistrict');
    Route::post('/insert/district',[App\Http\Controllers\DistrictController::class,'insert'])->name('InsertDistrict');

    Route::get('/create/taluka',[App\Http\Controllers\TalukaController::class,'index'])->name('CreateTaluka');
    Route::post('/insert/taluka',[App\Http\Controllers\TalukaController::class,'insert'])->name('InsertTaluka');

    Route::get('/create/Village/{id}',[App\Http\Controllers\VillageController::class,'index'])->name('CreateVillage');
    Route::post('/insert/Village',[App\Http\Controllers\VillageController::class,'insert']);//->name('InsertVillage');
    Route::get('/List/Village',[App\Http\Controllers\VillageController::class,'List'])->name('ListVillage');