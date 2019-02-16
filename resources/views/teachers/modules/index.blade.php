@extends('layouts.app')

@section('content')
<section>
        <div class="container-fluid">
          <div class="row">
             <div class="col-xl-3 col-sm-6 mb-3">
                 <a href="{{ route('modules.create') }}">
                        <button class="btn btn-primary">Add Module</button> 
                </a>
             </div>
          </div>
        </div>
    
       </section>
<div id="test">

</div>
  
         <section>
        <div class="container-fluid">
          <div class="row">
            @foreach($modules as $index => $module)
            <div class="col-xl-3 col-sm-6 mb-3">
              <div class="card text-white {{ $module_class[$index % 4] }} o-hidden h-100">
                <div class="card-header">
                  {{ $module->name }} <br>
                  Module {{ $index + 1 }}
                </div>
                <div class="card-body">
                  <div class="card-body-icon">
                    <i class="fas fa-fw fa-comments"></i>
                  </div>
                  @foreach($module->lessons as $lesson)
                  <div class="mr-5">Lesson {{ $lesson->order }}</div>
                  @endforeach
                </div>
                <div class="card-footer text-white small">
                    <a href="{{ route('lessons',['module_id' => $module->id]) }}" >
                            <span class="text-white">View Module</span>
                    </a>
                            {{-- <span class="float-right">
                                <i class="fas fa-angle-right"></i>
                            </span> --}}

                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
       </section>
@endsection
