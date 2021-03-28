<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\Model\Lesson;
use App\Model\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Series $series, StoreLessonRequest $request)
    {
        //
        try {
            $lesson = $series->lessons()->create($request->all());
            return response()->success($lesson, 200);
        } catch (\Throwable $ex) {
            return response()->error($ex->getMessage(), 400);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Series $series, Lesson $lesson)
    {
        try {
            return response()->success($lesson, 200);
        } catch (\Throwable $ex) {
            return response()->error($ex->getMessage(), 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Series $series, Lesson $lesson, UpdateLessonRequest $request)
    {
        //
        try {
            $lesson->update($request->all());
            return response()->success($lesson->fresh());
        }catch (\Throwable $ex){
            return response()->error($ex->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Series $series, Lesson $lesson)
    {
        //
        try {
            $lesson->delete();
            return response()->success();
        } catch (\Throwable $ex) {
            return response()->error($ex->getMessage());
        }

    }

}
