@extends('layouts.app')

@section('content')

<div id="test">

</div>
  
         <section>
             
            <create-test-form
            :questions_data='{{ $questions }}'
            action_url={{ route('lessons.test.update',['lesson_id' => $lesson_id,'test_id' => $test_id]) }}
            >
            @csrf 
            {{ method_field('PUT') }}
            </create-test-form>
        </div>
       </section>
@endsection
