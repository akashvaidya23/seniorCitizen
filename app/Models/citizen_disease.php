<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class citizen_disease extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable = [
        'Disease_start_date',
        'Disease_id',
        'created_at',
        'created_by',
        'Last_updated_at',
        'Last_updated_by',
    ];
}
