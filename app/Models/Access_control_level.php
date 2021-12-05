<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Access_control_level extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable = [
        'Role_id',
        'Page_id',
        'Action_id',
    ];
}