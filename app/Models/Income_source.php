<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income_source extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable = [
        'type_of_income_source',
        'Active',
    ];
}
