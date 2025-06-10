<?php

namespace App\Models\Postgre;


use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $table = 'postgre_topic';

    protected $fillable = [
        'academic_year_id',
        'name',
        'description',
    ];

    public function year()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id', 'id');
    }
    public function subTopics()
    {
        return $this->hasMany(SubTopic::class, 'topic_id');
    }

}
