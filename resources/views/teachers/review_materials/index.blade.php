
@extends('layouts.app')

@section('content')

    <div class="container-fluid">

        <!-- Breadcrumbs-->
        @include('layouts.partials.breadcrumbs')

        <!-- Page Content -->
        <h1>{{ $lesson->name }} - Review Materials</h1>
        <hr>


    </div>
    <!-- /.container-fluid -->

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 col-sm-6 mb-3">
                    <a href="{{ route('modules.lessons.review-materials.create', [
                        'lesson' => $lesson,
                        'module' => $lesson->module
                    ]) }}">
                        <button class="btn btn-primary">Add Review Material</button>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid">
            <div class="row colored-cards">
                @foreach ($lesson->review_materials as $reviewMaterial)
                <div class=" col-xl-3 col-lg-3 col-md-6 col-xs-12 mb-3">
                    <div class="card h-100">
                        <div class="card-header">


<span class="float-right">
  <a class="nav-link p-0  text-right" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="  false">
    <i class="fas fa-fw fa-cog text-light"></i>
  </a>
  <div class="dropdown-menu">
    <a href="{{ route('modules.lessons.review-materials.edit', ['review_material' => $reviewMaterial->id, 'lesson' => $reviewMaterial->lesson->id, 'module' => $reviewMaterial->lesson->module->id]) }}" class="p-2">Edit</a>
    <form action="{{ route('modules.lessons.review-materials.destroy', ['review_material' => $reviewMaterial->id, 'lesson' => $reviewMaterial->lesson->id, 'module' => $reviewMaterial->lesson->module->id]) }}" method="POST"
      onsubmit="return confirm('Are you sure?')">
        @csrf
        @method('DELETE')
      <a href="#" class="p-2" onclick="$(this).closest('form').submit()">
        Delete
      </a>
    </form>
  </div>
</span>

                            {{ $reviewMaterial->name }}
                        </div>

                        @if ($reviewMaterial->mime_type === 'application/x-shockwave-flash')
                            <object autoplay="false" width="100%" height="100%" data="/storage/review-materials/{{ $reviewMaterial->file_name }}"></object>

                        @else
                            <video width="100%" height="auto" controls>
                              <source src="/storage/review-materials/{{ $reviewMaterial->file_name }}" type="{{ $reviewMaterial->mime_type }}">
                            Your browser does not support the video tag.
                            </video>
                        @endif

                        <div class="card-body">
                            <p class="card-text">{{ $reviewMaterial->description }}</p>
                        </div>

                        <div class="card-footer">
                           <a href="{{ route('modules.lessons.review-materials.show', [
                                    'lesson' => $reviewMaterial->lesson,
                                    'module' => $reviewMaterial->lesson,
                                    'review_material' => $reviewMaterial
                                ]) }}">
                                <button class="btn btn-success">View Material</button>
                            </a>
                             <span class="float-right">
                               <form action="{{ route('modules.lessons.review-materials.update', [
                               'module' => $lesson->module,
                               'lesson' => $lesson,
                               'review_material' => $reviewMaterial,
                               ]) }}" method="POST">
                                  @csrf
                                  @method('PATCH')
                                  <label class="switch">
                                    <input type="checkbox" 
                                      name="is_open"  
                                        onclick="this.value=this.checked;this.form.submit()" 
                                        {{ $reviewMaterial->is_open ? 'checked' : ''}}>
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