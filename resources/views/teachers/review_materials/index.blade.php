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
                @foreach ($lesson->review_materials as $reviewMaterial)
                <div class=" col-xl-4 col-lg-4 col-md-6 col-xs-12 mb-3">
                    <div class="card text-black o-hidden h-100">
                        <div class="card-header">
                            {{ $reviewMaterial->name }}
                        </div>
                        <video class="p-1" width="240" height="200" controls>
                            <source src="/storage/review-materials/{{ $reviewMaterial->file_name }}" type="{{ $reviewMaterial->mime_type }}">
                            Your browser does not support the video tag.
                        </video>
                        <div class="card-body">
                            <p class="card-text">{{ $reviewMaterial->description }}</p>
                        </div>
                        <!--  <a class="card-footer text-white clearfix small z-1" href="#">
                           <span class="float-left">View Lesson</span>
                           <span class="float-right">
                             <i class="fas fa-angle-right"></i>
                           </span>
                         </a> -->
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    @endsection