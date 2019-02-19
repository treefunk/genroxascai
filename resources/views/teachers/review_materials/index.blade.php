
@extends('layouts.app')

@section('content')

    <div class="container-fluid">

        <!-- Breadcrumbs-->
        @include('layouts.partials.breadcrumbs')

        <!-- Page Content -->
        <h1>Review Materials Page</h1>
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
                    <div class="card text-white o-hidden h-100">
                        <div class="card-header">
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
                                <span class="text-white">View Material</span>
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