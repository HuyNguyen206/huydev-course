<?php

namespace App\Http\Controllers;

use App\Model\Series;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $series = Series::all();
        return view('layouts.index', compact('series'));
    }

    public function showSeries(Series $series){
        return view('frontend.series.show', compact('series'));
    }
}
