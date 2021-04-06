@extends('layouts.main-app')
@section('header')
    <header class="header header-inverse" style="background-color: #3498db;">
        <div class="container text-center">

            <div class="row">
                <div class="col-12 col-lg-8 offset-lg-2">

                    <h1>{{$user->name}}</h1>
                    <h1>{{$user->getTotalNumberOfCompletedLesson()}} </h1>
                    <p class="fs-20 opacity-70">Lesson completed</p>
                </div>
            </div>

        </div>
    </header>
@endsection
@section('content')
    <section class="section">
        <div class="container">
            <div class="row gap-y">
                <div class="col-12">
                    <h2 style="text-align: center">Series being watched ...</h2>
                </div>
            </div>
            <div class="row gap-y">
                @foreach($seriesBeingWatch as $series)
                <div class="col-12 col-md-6 col-xl-4">
                    <a class="shop-item" href="{{route('watch-series', $series->slug)}}">
                        <div class="item-details">
                            <div>
                                <h5>{{$series->title}}</h5>
                                <p>{{$series->description}}</p>
                            </div>
                        </div>
                        <img style="width: 100%;
    height: 200px;
    object-fit: cover;" src="{{$series->image_path}}" alt="product">
                    </a>
                </div>
                @endforeach
            </div>

        </div>
    </section>
    <section class="section bg-gray" id="section-vtab">
        <div class="container">
            <header class="section-header">
                <small>Content switcher</small>
                <h2>Edit your profile</h2>
                <hr>
                <p class="lead">A single content area with multiple panels, each associated with a header in a list.</p>
            </header>
            <div class="row gap-5">
                <div class="col-12 col-md-4">
                    <ul class="nav nav-vertical">
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#personal" aria-expanded="false">
                                <h6>Personal details</h6>
                                <p>Some description about tab</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#payment" aria-expanded="false">
                                <h6>Payment & Subscription</h6>
                                <p>Some description about tab</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#setting" aria-expanded="false">
                                <h6>Setting</h6>
                                <p>Some description about tab</p>
                            </a>
                        </li>
                    </ul>
                </div>


                <div class="col-12 col-md-8 align-self-center">
                    <div class="tab-content">
                        <div class="tab-pane fade" id="personal" aria-expanded="false">
                            <form action="http://huydev-course.com/admin/series/learning-laravel-and-vuejs-advance"
                                  method="POST" enctype="multipart/form-data"><input type="hidden" name="_method"
                                                                                     value="put"> <input type="hidden"
                                                                                                         name="_token"
                                                                                                         value="RFFFDKeQVpngWuPrdokFs8hLaZ27ZM0oX6ZYz1hf">
                                <div class="form-group"><input type="text"
                                                               name="name" placeholder="Your name"
                                                               class="form-control form-control-lg"></div>
                                <div class="form-group"><input type="text"
                                                               name="email" placeholder="Your email"
                                                               class="form-control form-control-lg"></div>

                                <button type="submit" class="btn btn-lg btn-primary btn-block">Save change</button>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="payment" aria-expanded="false">
                            <stripe-subscription current_plan_json="{{json_encode($subscriptionPlan)}}" plans_json="{{json_encode($plans)}}"></stripe-subscription>
                        </div>

                        <div class="tab-pane fade" id="setting" aria-expanded="false">
                            <p class="text-center"><img src="assets/img/blog-3.jpg" alt="..."></p>
                        </div>
                    </div>
                </div>


            </div>


        </div>
    </section>
@endsection
