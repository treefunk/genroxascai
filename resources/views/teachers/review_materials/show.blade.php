@extends('layouts.app')

@section('content')

    <div class="container-fluid">

        <!-- Breadcrumbs-->
        @include('layouts.partials.breadcrumbs')

        <!-- Page Content -->
        <h1>{{ $reviewMaterial->name }}</h1>
        <hr>


    </div>
    <!-- /.container-fluid -->

    <section style="height: 100%;">
        <div class="row" style="height: 100%;">
            <div class="col-12" style="height: 100%;">
                @if ($reviewMaterial->mime_type === 'application/x-shockwave-flash')
                    <object autoplay="false" width="100%" height="100%" data="/storage/review-materials/{{ $reviewMaterial->file_name }}"></object>

                @else
                    <video width="100%" height="100%" controls>
                      <source src="/storage/review-materials/{{ $reviewMaterial->file_name }}" type="{{ $reviewMaterial->mime_type }}">
                    Your browser does not support the video tag.
                    </video>
                @endif
            </div>
        </div>
    </section>

    @endsection