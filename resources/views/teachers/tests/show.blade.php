@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        @include('layouts.partials.breadcrumbs')
        <h1>{{ $test->type_name }} Page</h1>
        <hr>
    </div>

    <section>

        <div class="container-fluid">
    <a href="{{ route('test-student-answers', [
            'module' => ($test->lesson ? $test->lesson->module : $test->module),
            'test' => $test
        ]) }}">
        <button class="btn btn-success">View Student Answer</button>
    </a>
            @if ($test->lesson)
                <create-test-form
                    :is_open="{{ $test->is_open }}"
                    :passing_grade="{{ $test->passing_grade }}"
                    :time_limit="{{ $test->time_limit }}"
                    :limit="{{ $test->limit }}"
                    :questions_data='{{ $questions }}'
                    action_url={{ route('modules.lessons.test.update', [
                      'lesson' => $test->lesson->id,
                      'test' => $test,
                      'module' => $test->lesson->module->id
                    ]) }}
                >
                    @csrf
                    {{ method_field('PUT') }}
                </create-test-form>
            @else
                <create-test-form
                    :is_open="{{ $test->is_open }}"
                    :passing_grade="{{ $test->passing_grade }}"
                    :time_limit="{{ $test->time_limit }}"
                    :limit="{{ $test->limit }}"
                    :questions_data='{{ $questions }}'
                    action_url={{ route('modules.test.update', [
                      'test' => $test,
                      'module' => $test->module->id
                    ]) }}
                >
                    @csrf
                    {{ method_field('PUT') }}
                </create-test-form>
            @endif

        </div>
    </section>
@endsection
