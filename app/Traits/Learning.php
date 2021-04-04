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

    public function hasCompleteLesson($lesson){
        $key = $this->getKeyUserSeries($lesson->series->id);
        return in_array($lesson->id, Redis::smembers($key));
    }

    public function getSeriesBeingWatch(){
        $listKey = Redis::keys("user:$this->id:series:*");
        $seriesId = [];
        foreach ($listKey as $value){
            $seriesId[] = explode('series:', $value)[1];
        }
        return $seriesId ? Series::whereIn('id', $seriesId)->get() : $seriesId;
    }

    public function getTotalNumberOfCompletedLesson(){
        $listKey = Redis::keys("user:$this->id:series:*");
        $sum = 0;
        foreach ($listKey as $value){
            $sum += count(Redis::smembers($value));
        }
        return $sum;
    }

    public function getNextLessonToWatch($seriesId){
        $lessonWatchedId = Redis::smembers($this->getKeyUserSeries($seriesId));
        $lastLessonId = end($lessonWatchedId);
        return Lesson::find($lastLessonId)->getNextLesson();
    }
}
