<?php

namespace App\Models\Postgre;


use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'postgre_question';

    protected $fillable = [
        'title',
        'no',
        'sub_topic_id',
        'dbname',
        'description',
        'required_table',
        'test_code',
        'guide'
    ];

    public function subTopic()
    {
        return $this->belongsTo(SubTopic::class, 'sub_topic_id');
    }
}
