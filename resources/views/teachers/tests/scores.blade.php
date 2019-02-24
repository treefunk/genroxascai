@extends('layouts.app')

@section('content')

        <div class="container-fluid">
                        @include('layouts.partials.breadcrumbs')
                        <h1>{{ $test->type_name }} Scores</h1>
                        <h3>
                            Passing Mark: {{ $test->getPassingRate() }}
                        </h3>
                        <h4>
                            Number of Questions: {{ $test->getTotalQuestions() }}
                        </h4>
                        <hr>
                <hr>
    
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-table"></i>
                        Student Scores</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>First Name</th>
                                    <th>Middle Name</th>
                                    <th>Last Name</th>
                                    <th>Score</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>First Name</th>
                                    <th>Middle Name</th>
                                    <th>Last Name</th>
                                    <th>Score</th>
                                    <th>Status</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->firstname }}</td>
                                        <td>{{ $user->middlename }}</td>
                                        <td>{{ $user->lastname }}</td>
                                        <td>{{ ($usertest = $user->usertest()->where('test_id',$test->id)->first()) != null ? $usertest->getScore() : "N/A"}}</td>
                                        <td>{{ $usertest != null ? $usertest->getScoreStatus() : "N/A" }}</td>
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
@endsection
