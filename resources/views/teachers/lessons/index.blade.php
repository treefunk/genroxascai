@extends('layouts.app')

@section('content')

    <div id="content-wrapper">

        <div class="container-fluid">

            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.html">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="modules.html">Module 1</a>
                </li>
                <li class="breadcrumb-item active">Lessons</li>
            </ol>

            <!-- Page Content -->
            <h1>Lessons Page</h1>
            <hr>


        </div>
        <!-- /.container-fluid -->

        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-3 col-sm-6 mb-3">
                        <a href="{{ route('lessons.create',['module_id'=>$module_id]) }}"><button class="btn btn-primary">Add Lesson</button></a>
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
                                <img src="images/300x150.jpg"/>
                                <div class="card-body">

                                    <p class="card-text">{{$lesson->description}}</p>

                                </div>
                                <a class="card-footer text-black clearfix small z-1" href="{{route('lessons.show',[
                                'lesson_id' => $lesson->id
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

        <!-- Sticky Footer -->
        <footer class="sticky-footer">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright © Your Website 2019</span>
                </div>
            </div>
        </footer>

    </div>

    <table class="table">

    </table>
@endsection

