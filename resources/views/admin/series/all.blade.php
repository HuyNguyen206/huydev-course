@extends('layouts.main-app')
@section('header')
    <header class="header header-inverse" style="background-color: #c2b2cd;">
        <div class="container text-center">

            <div class="row">
                <div class="col-12 col-lg-8 offset-lg-2">

                    <h1>List series</h1>
                    <p class="fs-20 opacity-70">Customize your series lessons</p>

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
                    <table class="table">
                        <thead>
                        <th>
                            Stt
                        </th>
                        <th>
                            Title
                        </th>
                        <th>
                            Action
                        </th>
                        </thead>
                        <tbody>
                     @forelse($series as $serie)
                         <tr>
                             <td>
                                 {{$loop->iteration}}
                             </td>
                             <td>
                                 <a href="{{route('series.show', $serie->slug)}}">{{$serie->title}}</a>
                             </td>
                             <td>
                              <div class="btn-group">
                                  <a href="{{route('series.edit', $serie->slug)}}" class="btn btn-primary"> Edit</a>
                                  <form action="{{route('series.destroy', $serie->slug)}}" class="form-delete-{{$serie->id}}" method="post">
                                      @csrf
                                      @method('delete')
                                      <a href="#" class="btn btn-danger" onclick="event.preventDefault(); if(confirm('Are you sure to delete this series?'))
                                      {$('.form-delete-{{$serie->id}}').submit()} ">Delete</a>
                                  </form>

                              </div>
                             </td>
                         </tr>
                     @empty
                         <tr>
                             <td colspan="3">No data</td>
                         </tr>
                     @endforelse
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
    </div>
@endsection
