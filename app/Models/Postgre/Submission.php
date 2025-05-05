<?php

namespace App\Models\Postgre;


use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $table = 'postgre_submissions';

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