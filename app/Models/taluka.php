<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class taluka extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable = [
        'district_id',
        'taluka_name',
        'Active'
    ];
}
