<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class citizen_social_service extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable = [
        'social_service_id',
        'created_by',
        'Last_updated_at',
        'Last_updated_by',
    ];
}
