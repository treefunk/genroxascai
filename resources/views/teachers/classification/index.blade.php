@extends('layouts.app')

@section('content')

    <div class="container-fluid">

        @include('layouts.partials.breadcrumbs')

        <h1>Student Classification</h1>
        <hr>

        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-3 col-sm-6 mb-3">
                        <button class="btn btn-primary" onclick="window.location='{{ route("students.create") }}'">Add Student</button>
                    </div>
                </div>
            </div>
        </section>

        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-table"></i>
                Students</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Student</th>
                            <th>Classification</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Student</th>
                            <th>Classification</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->full_name }}</td>
                                <td>{{ ucwords($user->classification) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

@endsection

