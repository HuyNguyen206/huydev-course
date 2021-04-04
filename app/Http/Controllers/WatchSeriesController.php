<?php

namespace App\Http\Controllers;

use App\Model\Lesson;
use App\Model\Series;
use Illuminate\Http\Request;

class WatchSeriesController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Series $series){
        $user = auth()->user();
        if($user->hasStartSeries($series->id)){
            $nextLessonId = $user->getNextLessonToWatch($series->id)->id;
        }
        else{
            $nextLessonId =  $series->lessons()->first()->id;
        }
        return redirect()->route('watch-series.lesson', [
            'series'=> $series->slug,
            'lesson' => $nextLessonId
        ]);
    }

    public function watchLesson(Series $series, Lesson $lesson){
        return view('frontend.lesson.show', compact('lesson', 'series'));
    }

    public function completeLesson(Lesson $lesson){
        try {
            auth()->user()->completeLesson($lesson);
            return response()->success();
        }catch (\Throwable $ex){
            return response()->error($ex->getMessage());
        }

    }
}
