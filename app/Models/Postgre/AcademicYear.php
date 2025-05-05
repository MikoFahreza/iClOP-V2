<?php

namespace App\Models\Postgre;

use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    protected $table = 'postgre_academic_year';

    protected $fillable = [
        'name',
        'semester',
        'start_date',
        'end_date',
        'status',
    ];
}