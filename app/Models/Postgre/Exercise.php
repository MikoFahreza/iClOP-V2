<?php

namespace App\Models\Postgre;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    protected $table = 'postgre_exercise';

    protected $fillable = [
        'name',
        'description',
        'guide',
        'duration', // durasi dalam detik
    ];
}