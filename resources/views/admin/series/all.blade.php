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
                                 {{$serie->title}}
                             </td>
                             <td>
                              <div class="btn-group">
                                  <a href="" class="btn btn-primary"> Edit</a>
                                  <a href="" class="btn btn-danger"> Delete</a>
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
