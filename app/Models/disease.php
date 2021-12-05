<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class disease extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable = [
        'name_of_disease',
        'Active',
    ];
}
