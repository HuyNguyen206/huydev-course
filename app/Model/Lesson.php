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

    public function getNextLesson(){
        $orderLessons = $this->series->getOrderedLesson();
        $currentLessonIndex = $this->getCurrentLessonIndex($orderLessons);
        return $orderLessons[$currentLessonIndex+1] ?? null;
    }

    public function getPreviousLesson(){
        $orderLessons = $this->series->getOrderedLesson();
        $currentLessonIndex = $this->getCurrentLessonIndex($orderLessons);
        return $orderLessons[$currentLessonIndex-1] ?? null;
    }

    public function getCurrentLessonIndex($orderLessons){
        $currentLessonIndex = $orderLessons->search(function($lesson, $key){
            return $lesson->id == $this->id;
        });
        return $currentLessonIndex;
    }
}
