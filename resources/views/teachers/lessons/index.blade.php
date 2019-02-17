@extends('layouts.app')

@section('content')

        <div class="container-fluid">

            @include('layouts.partials.breadcrumbs')

            <!-- Page Content -->
            <h1>Lessons Page</h1>
            <hr>


        </div>
        <!-- /.container-fluid -->

        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-3 col-sm-6 mb-3">
                        <a href="{{ route('modules.lessons.create', ['module' => $module]) }}"><button class="btn btn-primary">Add Lesson</button></a>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="container-fluid">
                <div class="row">

                    @foreach ($lessons as $lesson)

                        <div class="col-xl-3 col-sm-6 mb-3">
                            <div class="card text-black bg-gray o-hidden h-100">
                                <div class="card-header">
                                    {{ $lesson->name }}
                                </div>
                                <img src="https://via.placeholder.com/350x150"/>
                                <div class="card-body">

                                    <p class="card-text">{{$lesson->description}}</p>

                                </div>
                                <a class="card-footer text-white clearfix small z-1" href="{{route('modules.lessons.show',[
                                    'lesson' => $lesson,
                                    'module' => $module,
                                ])}}">
                                    <span class="float-left">View Lesson</span>
                                    <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
                                </a>
                            </div>
                        </div>

                    @endforeach


                </div>
            </div>
        </section>

@endsection

