<?php

namespace App\Http\Controllers;

use App\Model\Lesson;
use App\Model\Series;
use Illuminate\Http\Request;

class WatchSeriesController extends Controller
{
    //
    public function index(Series $series){
        return redirect()->route('watch-series.lesson', [
            'series'=> $series->slug,
            'lesson' => $series->lessons()->first()->id
        ]);
    }

    public function watchLesson(Series $series, Lesson $lesson){
        return view('frontend.lesson.show', compact('lesson'));
    }
}
