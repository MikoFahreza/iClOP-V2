<?php

namespace App\Models\Postgre;


use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $table = 'postgre_topic';

    protected $fillable = [
        'name'
    ];

    public function subTopics()
    {
        return $this->hasMany(SubTopic::class, 'topic_id');
    }

}
