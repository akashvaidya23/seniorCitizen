<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class members extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $fillable = [
        'name_of_member',
        'Relation',
        'occupation',
        'lives_with_you',
        'Mobile_no',
        'created_at',
        'created_by',
        'Last_updated_at',
        'Last_updated_by',
    ];
}
