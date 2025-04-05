<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    protected $table = 'academic_year';

    protected $fillable = [
        'name',
        'semester',
        'start_date',
        'end_date',
        'status',
    ];
}