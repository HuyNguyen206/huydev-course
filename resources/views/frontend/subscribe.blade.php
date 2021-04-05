@extends('layouts.main-app')
@section('header')
    <header class="header header-inverse" style="background-color: #3498db;">
        <div class="container text-center">

            <div class="row">
                <div class="col-12 col-lg-8 offset-lg-2">
                    <h1>Subscribe plan</h1>
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
                    <stripe plans_json="{{json_encode($plans)}}" stripe_key="{{config('services.stripe.key')}}" user="{{$user}}" intent_json="{{json_encode($intent)}}"></stripe>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script src="https://js.stripe.com/v3/"></script>
@endsection
