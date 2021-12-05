<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ration_card_type extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable = [
        'type_of_ration_card',
        'Active',
    ];
}
