<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'question';

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
