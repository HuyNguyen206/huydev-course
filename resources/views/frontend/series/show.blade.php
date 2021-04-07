@extends('layouts.main-app')
@section('header')
    <header class="header header-inverse h-fullscreen pb-80" style="background-image: url({{$series->image_path}});"
            data-overlay="8">
        <div class="container text-center">

            <div class="row h-full">
                <div class="col-12 col-lg-8 offset-lg-2 align-self-center">

                    <h1 class="display-4 hidden-sm-down">{{$series->title}}</h1>
                    <h1 class="hidden-md-up">Create Professional Websites</h1>
                    <br>
                    <p class="lead text-white fs-20 hidden-sm-down">
                        {{$series->description}}
                    </p>
                    @auth
                        @hasStartSeries($series->id)
                            <a class="btn btn-lg btn-round btn-primary mr-16" @unless($series->lessons->count()) style=" pointer-events: none; color: #ccc;" @endunless  href="{{route('watch-series', $series->slug)}}">Continue the series</a>
                        @else
                            <a class="btn btn-lg btn-round btn-primary mr-16" @unless($series->lessons->count()) style=" pointer-events: none; color: #ccc;" @endunless href="{{route('watch-series', $series->slug)}}">Start the series</a>
                        @endhasStartSeries
                    @endauth
                    @guest
                        <a class="btn btn-lg btn-round w-200 btn-primary mr-16" @unless($series->lessons->count()) style=" pointer-events: none; color: #ccc;" @endunless href="{{route('watch-series', $series->slug)}}">Start the series</a>
                    @endguest
                </div>

                <div class="col-12 align-self-end text-center">
                    <a class="scroll-down-1 scroll-down-inverse" href="#"
                       data-scrollto="section-intro"><span></span></a>
                </div>

            </div>

        </div>
    </header>
@endsection
@section('content')

    <section class="section" id="section-intro">
        <div class="container">
            <header class="section-header">
                <small>Course Description</small>
                <h2>What is this course about?</h2>
                <hr>
                <p class="lead">{{$series->description}}
                    code</p>
            </header>

        </div>
    </section>

    <section class="section" id="section-intro">
        <div class="container">
            <header class="section-header">
                <h2>Video lesson</h2>
                <hr>
                <p class="lead">Lesson 1
                    code</p>
            </header>

        </div>
    </section>
@endsection
