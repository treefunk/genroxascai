@extends('layouts.app')

@section('content')

<h1>{{ $test->type_name }} Page</h1>
        <hr>

            <create-test-form
            :questions_data='{{ $questions }}'
            action_url={{ route('lessons.test.update',['lesson_id' => $lesson_id,'test_id' => $test_id]) }}
            >
            @csrf 
            {{ method_field('PUT') }}
            </create-test-form>

@endsection
