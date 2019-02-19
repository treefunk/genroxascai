@extends('layouts.app')

@section('content')
<section>
        <div class="container-fluid">
        @include('layouts.partials.breadcrumbs')
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
          <div class="row colored-cards">
            @foreach($modules as $index => $module)
            <div class="col-xl-3 col-sm-6 mb-3">
              <div class="card text-white o-hidden h-100">
                <div class="card-header">
                  {{ $module->name }} <br>
                  Module {{ $index + 1 }}
                </div>
                <div class="card-body">
                  <div class="card-body-icon">
                    <i class="fas fa-fw fa-list"></i>
                  </div>
                  @foreach($module->lessons as $lesson)
                  <div class="mr-5">Lesson {{ $lesson->order }} - {{ $lesson->name }}</div>
                  @endforeach
                </div>
                <div class="card-footer text-white small">
                    <a href="{{ route('modules.lessons.index',['module_id' => $module->id]) }}" >
                            <span class="text-white">View Module</span>
                    </a>
                     <span class="float-right">
                       <form action="{{ route('modules.update', ['module' => $module]) }}" method="POST">
                          @csrf
                          @method('PATCH')
                          <label class="switch">
                            <input type="checkbox" 
                              name="is_open"  
                                onclick="this.value=this.checked;this.form.submit()" 
                                {{ $module->is_open ? 'checked' : ''}}>
                            <span class="slider round"></span>
                          </label>
                        </form>
                    </span>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
       </section>
@endsection