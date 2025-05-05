<?php

namespace App\Models\Postgre;


use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'postgre_question';

    protected $fillable = [
        'title',
        'topic',
        'dbname',
        'description',
        'required_table',
        'test_code',
        'guide'
    ];
}
