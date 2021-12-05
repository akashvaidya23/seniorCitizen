<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class social_service_types extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable = [
        'type_of_social_service',
        'Active',
    ];
}
