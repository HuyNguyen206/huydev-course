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
                        @if($user->id == auth()->user()->id)
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#personal" aria-expanded="false">
                                <h6>Personal details</h6>
                                <p>Some description about tab</p>
                            </a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#payment" aria-expanded="false">
                                <h6>Payment & Subscription</h6>
                                <p>Some description about tab</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#card" aria-expanded="false">
                                <h6>Card info</h6>
                                <p>Some description about tab</p>
                            </a>
                        </li>
                    </ul>
                </div>


                <div class="col-12 col-md-8 align-self-center">
                    <div class="tab-content">
                        @if($user->id == auth()->user()->id)
                            <user-info name="{{$user->name}}" email="{{$user->email}}"></user-info>
                        @endif
                        <div class="tab-pane fade" id="payment" aria-expanded="false">
                            <stripe-subscription current_plan_json="{{json_encode($subscriptionPlan)}}" plans_json="{{json_encode($plans)}}"></stripe-subscription>
                        </div>

                        <div class="tab-pane fade" id="card" aria-expanded="false">
                            <stripe-card stripe_key="{{config('services.stripe.key')}}" card_brand="{{$user->card_brand}}" card_last_four="{{$user->card_last_four}}"></stripe-card>
                        </div>
                    </div>
                </div>


            </div>


        </div>
    </section>
@endsection

@section('script')
    <script src="https://js.stripe.com/v3/"></script>
@endsection
