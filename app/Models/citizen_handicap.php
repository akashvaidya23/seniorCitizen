<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class citizen_handicap extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable = [
        'Handicap_id',
        'Handicap_percentage',
        'created_at',
        'created_by',
        'Last_updated_at',
        'Last_updated_by',
    ];
}
