@extends('layouts.main-app')

@section('content')

    <div class="section">
        <div class="container">

            <div class="row gap-y">
                <div class="col-12">

                    <form action="{{route('series.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="alert alert-success">We received your message and will contact you back soon.</div>

                        <div class="form-group">
                            <input class="form-control form-control-lg" type="text" name="title" placeholder="Title">
                        </div>

                        <div class="form-group">
                            <input class="form-control form-control-lg" type="file" name="image" placeholder="">
                        </div>

                        <div class="form-group">
                            <textarea class="form-control form-control-lg" name="description" rows="4" placeholder="Description"></textarea>
                        </div>

                        <button class="btn btn-lg btn-primary btn-block" type="submit">Create Series</button>
                    </form>

                </div>
            </div>


        </div>
    </div>
@endsection
