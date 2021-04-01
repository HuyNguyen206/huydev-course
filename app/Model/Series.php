<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    //
    protected $guarded = [];
    protected $with = ['lessons'];
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function lessons(){
        return $this->hasMany(Lesson::class, 'series_id');
    }

    public function getImagePathAttribute(){
        return asset('storage').'/'.$this->image_url;
    }

    public function getOrderedLesson(){
       return $this->lessons->sortBy(['episode_number'])->values();
    }
}
