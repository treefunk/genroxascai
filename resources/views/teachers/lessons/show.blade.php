@extends('layouts.app')

@section('content')
<div id="test">

</div>
  
         <section>
             <h4>Lesson #{{ $lesson->order }}</h4>
             <h1>{{ $lesson->name }}</h1>
        <div class="container-fluid">
            <button class="btn btn-default">Review Materials</button>
            <a href="{{ route('lessons.show',$lesson->pre_test->id) }}">
                <button class="btn btn-default">Pre test</button>
            </a>

            <button class="btn btn-default">Post Test</button>

            <button class="btn btn-default">Drills</button>
        </div>
       </section>
@endsection
