@extends('layouts.app')

@section('content')

    <div class="container-fluid">

        @include('layouts.partials.breadcrumbs')

        <h1>Attendance</h1>
        <hr>

        <section>
            <div class="container-fluid">
                <form action="" method="get" class="form-inline">
                    <div class="form-group mb-3 pr-2">
                        <label class="pr-2">Date Filter</label>
                        <input type="date" name="date" value="{{ $date }}" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </section>

        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-table"></i>
                Attendance</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Student Name</th>
                            <th>Status</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->full_name }}</td>
                                <td>
                                    @if ($user->getLoginByDate($date))
                                    <p class="text-success">Login :  {{ $user->getLoginByDate($date)->login }} </p>
                                    @endif

                                    @if ($user->getLogoutByDate($date))
                                        <p class="text-danger">Logout : {{ $user->getLogoutByDate($date)->logout }} </p>
                                    @endif
                                </td>
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

