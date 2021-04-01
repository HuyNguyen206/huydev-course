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
                    @php
                        $nextLesson = $lesson->getNextLesson();
                    @endphp
                    <vimeo video_id="{{$lesson->video_id}}"
                           next_lesson_url="{{$nextLesson ? route('watch-series.lesson', ['series' => $series->slug, 'lesson' => $nextLesson->id]) : null}}"></vimeo>
                    <div class="text-center my-3">
                        @if($previousLesson = $lesson->getPreviousLesson())
                            <a href="{{route('watch-series.lesson', ['series' => $series->slug, 'lesson' => $previousLesson->id])}}"
                               class="btn btn-info">Previous Lesson</a>
                        @endif
                        @if($nextLesson)
                            <a href="{{route('watch-series.lesson', ['series' => $series->slug, 'lesson' => $nextLesson->id])}}"
                               class="btn btn-info">Next Lesson</a>
                        @endif
                    </div>
                    <div>
                        <ul class="list-group">
                            @foreach($series->getOrderedLesson() as $les)
                                <li class="list-group-item  {{$lesson->id == $les->id ? 'active-lesson' : ''}}">
                                    <a class=" d-flex" style="width: 100%"
                                       href="{{route('watch-series.lesson', ['series' => $series->slug, 'lesson' => $les->id])}}">
                                        <span class="mr-2 d-inline-block">  Episode Number {{$les->episode_number}} </span>
                                        <span class="d-inline-block"> {{$les->title}}</span> </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
@section('css')
    <style>
        .list-group-item a {
            color: black;
            padding: 15px;
        }
        .active-lesson {
            background: #D4D9EE;
        }
        .list-group-item a:hover{
            background: #d4d9ee47;
            transition: .4s;
        }
        .list-group-item{
            padding: 0;
        }
    </style>
@endsection
