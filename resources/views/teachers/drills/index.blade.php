@php
use Illuminate\Support\Facades\Auth;
@endphp
@extends('layouts.app')

@section('content')

    <div class="container-fluid">

        <!-- Breadcrumbs-->
        @include('layouts.partials.breadcrumbs')

        <!-- Page Content -->
        <h1>{{ $lesson->name }} - Drills</h1>
        <hr>


    </div>
    <!-- /.container-fluid -->

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 col-sm-6 mb-3">
                    <a href="{{ route('modules.lessons.drills.create', [
                        'lesson' => $lesson,
                        'module' => $lesson->module
                    ]) }}">
                        <button class="btn btn-primary">Add Drill</button>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid">
            <div class="row colored-cards">
                @foreach ($lesson->drills as $drill)
                <div class=" col-xl-3 col-lg-3 col-md-6 col-xs-12 mb-3">
                    <div class="card h-100">
                        <div class="card-header">


<span class="float-right">
  <a class="nav-link p-0  text-right" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="  false">
    <i class="fas fa-fw fa-cog text-light"></i>
  </a>
  <div class="dropdown-menu">
    <a href="{{ route('modules.lessons.drills.edit', ['drill' => $drill->id, 'lesson' => $drill->lesson->id, 'module' => $drill->lesson->module->id]) }}" class="p-2">Edit</a>
    @if (Auth::user()->is_admin)
    <form action="{{ route('modules.lessons.drills.destroy', ['drill' => $drill->id, 'lesson' => $drill->lesson->id, 'module' => $drill->lesson->module->id]) }}" method="POST"
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

                            {{ $drill->name }}
                        </div>

                        <p class="p-2">
                          {{ $drill->instructions }}
                        </p>

                        @if ($drill->mime_type === 'application/x-shockwave-flash')
                            <object autoplay="false" width="100%" height="100%" data="/storage/drills/{{ $drill->file_name }}"></object>

                        @else
                            <video width="100%" height="auto" controls>
                              <source src="/storage/drills/{{ $drill->file_name }}" type="{{ $drill->mime_type }}">
                            Your browser does not support the video tag.
                            </video>
                        @endif

                        <div class="card-body">
                            <p class="card-text">{{ $drill->description }}</p>
                        </div>

                        <div class="card-footer">
                           <a href="{{ route('modules.lessons.drills.show', [
                                    'lesson' => $drill->lesson,
                                    'module' => $drill->lesson,
                                    'drill' => $drill
                                ]) }}">
                                <button class="btn btn-success">View</button>
                            </a>
                             <span class="float-right">
                               <form action="{{ route('modules.lessons.drills.update', [
                               'module' => $lesson->module,
                               'lesson' => $lesson,
                               'drill' => $drill,
                               ]) }}" method="POST">
                                  @csrf
                                  @method('PATCH')
                                  <label class="switch">
                                    <input type="checkbox" 
                                      name="is_open"  
                                        onclick="this.value=this.checked;this.form.submit()" 
                                        {{ $drill->is_open ? 'checked' : ''}}>
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