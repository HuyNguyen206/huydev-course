<?php

use Illuminate\Support\Facades\Route;


Route::resource('series', 'SeriesController');
Route::resource('{series_by_id}/lessons', 'LessonController');
