@extends('layouts.app')

@section('content')

    <div class="container-fluid">

        @include('layouts.partials.breadcrumbs')

        <h1>Teachers</h1>
        <hr>

        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-3 col-sm-6 mb-3">
                        <button class="btn btn-primary" onclick="window.location='{{ route("teachers.create") }}'">Add Teacher</button>
                    </div>
                </div>
            </div>
        </section>

        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-table"></i>
                Teachers</div>
            <div class="card-body">
                @include('components.users.index')
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

@endsection

