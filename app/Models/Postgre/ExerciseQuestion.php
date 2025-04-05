<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExerciseQuestion extends Model
{

    protected $table = 'exercise_question';

    protected $fillable = [
        'exercise_id',
        'question_id',
        'no',
        'isRemoved',
    ];

    public function exercise()
    {
        return $this->belongsTo(Exercise::class, 'exercise_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}