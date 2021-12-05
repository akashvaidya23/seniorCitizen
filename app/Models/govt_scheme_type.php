<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class govt_scheme_type extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable = [
        'type_of_govt_scheme',
        'Active',
    ];
}
