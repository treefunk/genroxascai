@php
use Illuminate\Support\Facades\Auth;
@endphp
@extends('layouts.app')

@section('content')
<section>
        <div class="container-fluid">
        @include('layouts.partials.breadcrumbs')
          <div class="row">
             <div class="col-xl-3 col-sm-6 mb-3">
                 <a href="{{ route('modules.create') }}">
                        <button class="btn btn-primary">Magdagdag ng Yunit</button> 
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
              <div class="card h-100">
                <div class="card-header">


<span class="float-right">
  <a class="nav-link p-0  text-right" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="  false">
    <i class="fas fa-fw fa-cog text-light"></i>
  </a>
  <div class="dropdown-menu">
    <a href="{{ route('modules.edit',['module' => $module->id]) }}" class="p-2">Edit</a>
    @if (Auth::user()->is_admin)
    <form action="{{ route('modules.destroy', ['module' => $module->id]) }}" method="POST"
      onsubmit="return confirm('Are you sure?')">
        @csrf
        @method('DELETE')
      <a href="#" class="p-2" onclick="$(this).closest('form').submit()">
        Delete
      </a>
    </form>
    @endif
  </div>
</span>
                  {{ $module->name }} <br>
                  Yunit {{ $index + 1 }}
                </div>


                <div class="card-body">
                  <div>
                  @if ($module->file_name)
                      <img style="max-width: 100%;" src="/storage/images/modules/{{ $module->file_name }}"/>
                  @else
                      <img style="max-width: 100%;" src="/images/default-image-module.png"/>
                  @endif
                  </div>
         
                  @foreach($module->lessons as $lesson)
                  <div class="mr-5">Lesson {{ $lesson->order }} - {{ $lesson->name }}</div>
                  @endforeach
                </div>
                <div class="card-footer small">
                    <a href="{{ route('modules.lessons.index',['module_id' => $module->id]) }}" >
                            <button class="btn btn-success">Mga Aralin</button>
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