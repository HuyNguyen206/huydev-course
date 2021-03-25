@extends('layouts.main-app')
@section('header')
    <header class="header header-inverse h-fullscreen p-0 bg-primary overflow-hidden"
            style="background-image: linear-gradient(to right, #434343 0%, black 100%);">
        <canvas class="constellation"></canvas>

        <div class="container text-center">

            <div class="row h-full align-items-center">
                <div class="col-12 col-md-8 offset-md-2">

                    <h1 class="display-4">NORA</h1>
                    <br>
                    <p class="lead text-white fs-20">Nora is an awesome web development learning subscription baseed SaaS
                        application powered with Vuejs and Laravel.</p>
                    <br>
                    <a class="btn btn-xl btn-round btn-primary" href="#">Start a project</a>
                    <a class="btn btn-xl btn-round btn-outline-primary" href="#">Feature</a>

                </div>
            </div>

        </div>
    </header>
@endsection
