@extends('layouts.app')

@section('content')

    <div class="container-fluid">

        <!-- Breadcrumbs-->
        @include('layouts.partials.breadcrumbs')

        <!-- Page Content -->
        <h1>Review Materials Page</h1>
        <hr>


    </div>
    <!-- /.container-fluid -->

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 col-sm-6 mb-3">
                    <a href="{{ route('modules.lessons.review-materials.create', [
                        'lesson' => $lesson,
                        'module' => $lesson->module
                    ]) }}">
                        <button class="btn btn-primary">Add Review Material</button>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 col-sm-6 mb-3">
                    <div class="card text-black  o-hidden h-100">
                        <div class="card-header">
                            Review Material 1
                        </div>
                        <img src="images/300x150.jpg"/>
                        <div class="card-body">

                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>

                        </div>
                        <!--  <a class="card-footer text-white clearfix small z-1" href="#">
                           <span class="float-left">View Lesson</span>
                           <span class="float-right">
                             <i class="fas fa-angle-right"></i>
                           </span>
                         </a> -->
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 mb-3">
                    <div class="card text-black  o-hidden h-100">
                        <div class="card-header">
                            Review Material 2
                        </div>
                        <img src="images/300x150.jpg"/>
                        <div class="card-body">

                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>

                        </div>

                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-3">
                    <div class="card text-black  o-hidden h-100">
                        <div class="card-header">
                            Review Material 3
                        </div>
                        <img src="images/300x150.jpg"/>
                        <div class="card-body">

                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    @endsection