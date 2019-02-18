
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

                        @if ($reviewMaterial->mime_type === 'application/x-shockwave-flash')
                            <object autoplay="false" width="100%" height="100%" data="/storage/review-materials/{{ $reviewMaterial->file_name }}"></object>

                        @else
                            <video width="320" height="240" controls>
                              <source src="/storage/review-materials/{{ $reviewMaterial->file_name }}" type="{{ $reviewMaterial->mime_type }}">
                            Your browser does not support the video tag.
                            </video>
                        @endif

                        <div class="card-body">
                            <p class="card-text">{{ $reviewMaterial->description }}</p>
                        </div>

                        <div class="card-footer">
                           <a href="{{ route('modules.lessons.review-materials.show', [
                                    'lesson' => $reviewMaterial->lesson,
                                    'module' => $reviewMaterial->lesson,
                                    'review_material' => $reviewMaterial
                                ]) }}">
                                <span class="float-left">View Material</span>
                            </a>
                        </div>      
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    @endsection