<?php

namespace App\Models\Postgre;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $table = 'postgre_exercise';

    protected $fillable = [
        'academic_year_id',
        'name',
        'description',
    ];

    public function year()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id', 'id');
    }
}