@extends('layouts.app')

@section('content')
<div id="content-wrapper">

    <div class="container-fluid">

        @include('layouts.partials.breadcrumbs')

        <h1>Students</h1>
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
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Last Name</th>
                            <th>Gender</th>
                            <th>Birth Date</th>
                            <th>Address</th>
                            <th>Contact</th>
                            <th>Email</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Last Name</th>
                            <th>Gender</th>
                            <th>Birth Date</th>
                            <th>Address</th>
                            <th>Contact</th>
                            <th>Email</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->firstname }}</td>
                                <td>{{ $user->middlename }}</td>
                                <td>{{ $user->lastname }}</td>
                                <td>{{ ucfirst($user->gender) }}</td>
                                <td>{{ Carbon\Carbon::parse($user->birthdate)->format('M j, Y') }}</td>
                                <td>{{ $user->address }}</td>
                                <td>{{ $user->contact }}</td>
                                <td>{{ $user->email }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content-wrapper -->
@endsection

