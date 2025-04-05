<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassesStudent extends Model
{
    protected $table = 'class_student';

    protected $fillable = [
        'class_id',
        'student_id',
    ];

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id', 'id');
    }
}