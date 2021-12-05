<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class village extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable = [
        'District_id',
        'Taluka_id',
        'name_of_village',
        'Active',
    ];
}
