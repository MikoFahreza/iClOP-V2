<?php

namespace App\Models\Postgre;

use Illuminate\Database\Eloquent\Model;

class ClassesStudent extends Model
{
    protected $table = 'postgre_class_student';

    protected $fillable = [
        'class_id',
        'student_id',
    ];

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id', 'id');
    }
}