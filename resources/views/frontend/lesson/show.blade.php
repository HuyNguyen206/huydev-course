@extends('layouts.main-app')
@section('header')
    <header class="header header-inverse" style="background-color: #3498db;">
        <div class="container text-center">

            <div class="row">
                <div class="col-12 col-lg-8 offset-lg-2">

                    <h1>{{$lesson->title}}</h1>
                    <p class="fs-20 opacity-70">{{$lesson->description}}</p>

                </div>
            </div>

        </div>
    </header>
@endsection
@section('content')

    <div class="section">
        <div class="container">
            <div class="row gap-y">
                <div class="col-12">
                    <vimeo video_id="{{$lesson->video_id}}"></vimeo>
                </div>
            </div>


        </div>
    </div>
@endsection
