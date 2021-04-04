@extends('layouts.main-app')
@section('header')
    <header class="header header-inverse" style="background-color: #3498db;">
        <div class="container text-center">

            <div class="row">
                <div class="col-12 col-lg-8 offset-lg-2">

                    <h1>Welcome {{auth()->user()->name}}. Our new subscribe</h1>
                </div>
            </div>

        </div>
    </header>
@endsection

