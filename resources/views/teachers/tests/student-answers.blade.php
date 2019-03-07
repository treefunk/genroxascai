@extends('layouts.app')

@section('content')

        <div class="container-fluid">
                @include('layouts.partials.breadcrumbs')
                <h1>{{ $test->type_name }} Student Answers</h1>
                <hr>

                <div class="card mb-3">
                    <div class="card-header">
                    @foreach ($test->questions as $question)
                        {{ $loop->index + 1 }}. {{ $question->text }} <br>
                    @endforeach

                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-table"></i>
                        Student Answers</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Student Name</th>
                                    @foreach ($test->questions as $question)
                                        <th>Q# {{ $loop->index + 1 }}</th>
                                    @endforeach
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Student Name</th>
                                    @foreach ($test->questions as $question)
                                        <th>Q# {{ $loop->index + 1 }}</th>
                                    @endforeach
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->full_name }}</td>
                                        @foreach ($test->questions as $question)
                                        <td>
                                            @php
                                                $userTest = $user->getHighestUserTestByTest($test)
                                            @endphp
                                            @if ($userTest)
                                                @if ($userTest->isUserCorrectInQuestion($question))
                                                    <p class="text-success">Correct</p>
                                                @else
                                                    <p class="text-danger">Wrong</p>
                                                @endif
                                            @endif
                                        </td>
                                        @endforeach
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
