<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class relations extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable = [
        'type_of_relation',
        'Active',
    ];
}
