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
            <li class="breadcrumb-item">
                <a href="modules.html">Lessons</a>
            </li>
            <li class="breadcrumb-item">
                <a href="modules.html">Lesson 1</a>
            </li>
            <li class="breadcrumb-item active">Review Materials</li>

        </ol>

        <!-- Page Content -->
        <h1>Review Materials Page</h1>
        <hr>


    </div>
    <!-- /.container-fluid -->

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 col-sm-6 mb-3">
                    <button class="btn btn-primary">Add Review Material</button>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-sm-12 mb-3">
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%">Uploading...</div>
                    </div>
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

    <!-- Sticky Footer -->
    <footer class="sticky-footer">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright © Your Website 2019</span>
            </div>
        </div>
    </footer>

</div>
    @endsection