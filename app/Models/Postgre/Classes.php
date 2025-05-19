<?php

namespace App\Models\Postgre;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $table = 'postgre_class';

    protected $fillable = [
        'academic_year_id',
        'teacher_id',
        'name'
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class);
    }

    public function year()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id', 'id');
    }
}