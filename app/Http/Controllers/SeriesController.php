<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSeriesRequest;
use App\Http\Requests\UpdateSeriesRequest;
use App\Model\Lesson;
use App\Model\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SeriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $series = Series::latest()->get();
        return view('admin.series.all',compact('series'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.series.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSeriesRequest $request)
    {
        //
       return $request->uploadImage()
                ->storeSeries();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Series $series)
    {
        //
      return view('admin.series.index', compact('series'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Series $series)
    {
        //
        return view('admin.series.edit', compact('series'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Series $series, UpdateSeriesRequest $request)
    {
        try {
            $data = $request->all();
            if($request->has('image')){
                $imagePath = $request->uploadImage()->imagePath;
                if(Storage::exists($series->image_url)){
                    Storage::delete($series->image_url);
                }
                $data['image_url'] = $imagePath;
            }
            unset($data['image']);
            $data['slug'] = Str::slug($request->title);
            $series->update($data);
            return redirect()->route('series.index')->with('success','Series was created success!');
        }catch (\Throwable $ex)
        {
            return response()->error($ex->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
