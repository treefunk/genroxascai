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
                <object width="100%" height="100%" data="/storage/review-materials/{{ $reviewMaterial->file_name }}"></object>
            </div>
        </div>
    </section>

    @endsection