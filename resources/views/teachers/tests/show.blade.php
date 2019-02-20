@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        @include('layouts.partials.breadcrumbs')
        <h1>{{ $test->type_name }} Page</h1>
        <hr>
    </div>

    <section>
        <div class="container-fluid">
            <create-test-form
                :is_open="{{ $test->is_open }}"
                :passing_grade="{{ $test->passing_grade }}"
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
        </div>
    </section>
@endsection
