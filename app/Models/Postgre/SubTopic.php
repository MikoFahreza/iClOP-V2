<?php

namespace App\Models\Postgre;


use Illuminate\Database\Eloquent\Model;

class SubTopic extends Model
{
    protected $table = 'postgre_sub_topic';

    protected $fillable = [
        'name',
        'topic_id'
    ];

    public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id');
    }

}
