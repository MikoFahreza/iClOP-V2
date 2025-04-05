<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $table = 'submissions';

    protected $fillable = [
        'student_id',
        'question_id',
        'status',
        'solution'
    ];

    public function soal()
    {
        return $this->belongsTo(Question::class, 'question_id', 'id');
    }
}