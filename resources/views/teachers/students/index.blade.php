@php
use Illuminate\Support\Facades\Auth;
@endphp
@extends('layouts.app')

@section('content')

    <div class="container-fluid">

        @include('layouts.partials.breadcrumbs')

        <h1>Students</h1>
        <hr>

        @if (Auth::user()->is_admin)
        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-3 col-sm-6 mb-3">
                        <button class="btn btn-primary" onclick="window.location='{{ route("students.create") }}'">Add Student</button>
                    </div>
                </div>
            </div>
        </section>
        @endif


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

