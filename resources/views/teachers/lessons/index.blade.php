@extends('layouts.app')

@section('content')

    <div id="content-wrapper">

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
                            <div class="card text-white bg-primary o-hidden h-100">
                                <div class="card-header">
                                    {{ $lesson->name }}
                                </div>
                                <img src="images/300x150.jpg"/>
                                <div class="card-body">

                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>

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

