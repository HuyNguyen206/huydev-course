<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    //
    protected $guarded = [];

    public function series(){
        return $this->belongsTo(Series::class, 'series_id');
    }
}
