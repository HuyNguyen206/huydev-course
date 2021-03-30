<?php
namespace App\Traits;

use App\Model\Lesson;
use App\Model\Series;
use Illuminate\Support\Facades\Redis;

trait Learning {
    public function completeLesson($lesson){
        $key = $this->getKeyUserSeries($lesson->series_id);
        Redis::sadd($key,$lesson->id);
    }

    public function percentageCompleteForSeries($seriesId)
    {
        $numberLessonAlreadyComplete = $this->getNumberCompletedLessonBySeries($seriesId);
        return $numberLessonAlreadyComplete/(Series::find($seriesId)->lessons ->count())*100;
    }

    public function getNumberCompletedLessonBySeries($seriesId){
        return count(Redis::smembers($this->getKeyUserSeries($seriesId)));
    }

    public function getKeyUserSeries($seriesId){
        return "user:$this->id:series:$seriesId";
    }

    public function hasStartSeries($seriesId){
        return $this->getNumberCompletedLessonBySeries($seriesId) > 0;
    }

    public function getCompletedLessonBySeries($seriesId){
        $arrayCompletedLessonId = Redis::smembers($this->getKeyUserSeries($seriesId));
        $lessons = Lesson::whereIn('id', $arrayCompletedLessonId)->get();
        return $lessons;
    }
}
