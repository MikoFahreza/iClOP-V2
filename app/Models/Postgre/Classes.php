<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $table = 'class';

    protected $fillable = [
        'academic_year_id',
        'teacher_id',
        'name'
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function year()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id', 'id');
    }
}