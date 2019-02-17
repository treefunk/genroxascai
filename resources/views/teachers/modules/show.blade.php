@extends('layouts.app')

@section('content')
 <!-- Page Content -->
 
 <section>
     <div class="container-fluid">
     @include('layouts.partials.breadcrumbs')
            <h1>{{ $module->name }}</h1>
            <p>Module {{ $module->order }}</p>
            <hr>
 <div class="row">

    @foreach($module->lessons as $index => $lesson)
    <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white {{ $lesson_class[$index % 4] }} o-hidden h-100">
              <div class="card-header">
                Lesson {{ $lesson->order }}
              </div>
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-comments"></i>
                </div>
                <div class="mr-5">Review Materials</div>
                <div class="mr-5">Pre - Test</div>
                <div class="mr-5">Post - Test</div>
                <div class="mr-5">Drills</div>
              
              </div>
              <a class="card-footer text-white clearfix small z-1" href="{{ route('modules.lessons.show', [
                'module' => $lesson->module,
                'lesson' => $lesson
              ]) }}">
                <span class="float-left">View Lesson</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>

    @endforeach
   
   
     </div>
   </div>
 </div>
</div>
</section>   
@endsection