@extends('layouts.app')

@section('content')

    <div class="container-fluid">

        @include('layouts.partials.breadcrumbs')

        <h1>Students</h1>
        <hr>

        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-table"></i>
                Students</div>
            <div class="card-body">
                @include('components.users.index')
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

@endsection

