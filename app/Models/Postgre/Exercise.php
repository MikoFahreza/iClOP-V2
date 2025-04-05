<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $table = 'exercise';

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