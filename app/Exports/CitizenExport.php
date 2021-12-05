<?php

namespace App\Exports;

use App\Models\details_of_citizen;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CitizenExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function headings():array{
        return [
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
        'Last_updated_by'
        ];
    }

    public function collection()
    {
        //return details_of_citizens::all();
        return collect(details_of_citizen::getCitizens());
    }
}
