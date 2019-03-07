@extends('layouts.app')

@section('content')

        <div class="container-fluid">
                @include('layouts.partials.breadcrumbs')
                <h1>{{ $test->type_name }} Scores</h1>
                <h4>
                    Passing Mark: {{ $test->getPassingRate() }}
                </h4>
                <h4>
                    Number of Questions: {{ $test->getTotalQuestions() }}
                </h4>
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
                                    <th>Student Name</th>
                                    <th>No. of Attempts</th>
                                    <th>Highest Score Taken</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Student Name</th>
                                    <th>No. of Attempts</th>
                                    <th>Highest Score Taken</th>
                                    <th>Status</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->full_name }}</td>
                                        <td>{{ $user->getUserTestsByTest($test)->count() }}</td>
                                        @if ($user->getHighestUserTestByTest($test))
                                            <td>{{ $user->getHighestUserTestByTest($test)->score }}  / {{ $test->questions()->count()  }}</td>
                                            <td class="test-status-{{ $user->getHighestUserTestByTest($test)->score_status }}">
                                                {{ ucfirst($user->getHighestUserTestByTest($test)->score_status) }}
                                            </td>
                                        @else
                                            <td>N/A</td>
                                            <td>N/A</td>
                                        @endif

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
