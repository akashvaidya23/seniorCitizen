<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tool_type extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable = [
        'type_of_tools',
        'Active',
    ];
}
