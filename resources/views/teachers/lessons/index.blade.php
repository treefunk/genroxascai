@extends('layouts.app')

@section('content')

        <div class="container-fluid">

            @include('layouts.partials.breadcrumbs')

            <!-- Page Content -->
            <h1>{{ $module->name }} - Lessons</h1>
            <hr>


        </div>
        <!-- /.container-fluid -->

        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-3 col-sm-6 mb-3">
                        <a href="{{ route('modules.lessons.create', ['module' => $module]) }}"><button class="btn btn-primary">Add Lesson</button></a>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="container-fluid">
                <div class="row colored-cards">

                    @foreach ($lessons as $lesson)

                        <div class="col-xl-3 col-sm-6 mb-3">
                            <div class="card text-white bg-gray h-100">
                                <div class="card-header">


<span class="float-right">
  <a class="nav-link p-0  text-right" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="  false">
    <i class="fas fa-fw fa-cog text-light"></i>
  </a>
  <div class="dropdown-menu">
    <a href="{{ route('modules.lessons.edit',['lesson' => $lesson->id, 'module' => $lesson->module->id]) }}" class="p-2">Edit</a>
    <form action="{{ route('modules.lessons.destroy', ['lesson' => $lesson->id, 'module' => $lesson->module->id]) }}" method="POST"
      onsubmit="return confirm('Are you sure?')">
        @csrf
        @method('DELETE')
      <a href="#" class="p-2" onclick="$(this).closest('form').submit()">
        Delete
      </a>
    </form>
  </div>
</span>
                                    {{ $lesson->name }}
                                </div>
                                <div class="card-body">

                                    <p class="card-text">{{$lesson->description}}</p>

                                </div>
                                <div class="card-footer">
                                    <a class="text-white clearfix small z-1" href="{{route('modules.lessons.show',[
                                            'lesson' => $lesson,
                                            'module' => $module,
                                        ])}}">
                                        <span class="float-left">View Lesson</span>
                                        <span class="float-right">
                                            <form action="{{ route('modules.lessons.update', [
                                            'lesson' => $lesson,
                                            'module' => $lesson->module
                                            ]) }}" method="POST">
                                              @csrf
                                              @method('PATCH')
                                              <label class="switch">
                                                <input type="checkbox" 
                                                  name="is_open"  
                                                    onclick="this.value=this.checked;this.form.submit()" 
                                                    {{ $lesson->is_open ? 'checked' : ''}}>
                                                <span class="slider round"></span>
                                              </label>
                                            </form>
                                        </span>
                                    </a>
                                </div>  
                            </div>
                        </div>

                    @endforeach


                </div>
            </div>
        </section>

@endsection

