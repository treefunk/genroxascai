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

        <form id="form-review-material-create" action="{{ route('modules.lessons.review-materials.update', [
            'module' => $reviewMaterial->lesson->module,
            'lesson' => $reviewMaterial->lesson,
            'review_material' => $reviewMaterial,
        ]) }}" method="POST" enctype="multipart/form-data" onsubmit="showLoading()">
            @csrf
            @method('PATCH')
            <input type="hidden" name="is_open" value="{{ $reviewMaterial->is_open }}">
            <section>
                <div class="row">
                    <div class="col-xl-12 col-sm-12 input-group mb-3">

                        <label class="col-sm-2 col-form-label" class="">Name</label>

                        <div class="col-sm-8">
                            <input required type="text" id="name" name="name" class="form-control"  placeholder="" value="{{ $reviewMaterial->name }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-sm-12 input-group mb-3">

                        <label class="col-sm-2 col-form-label" class="">Description</label>

                        <div class="col-sm-8">
                            <textarea required rows="2" id="description" name="description" class="form-control">{{ $reviewMaterial->description }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12 col-sm-12 input-group mb-3">
                        <label class="col-sm-2 col-form-label" class="">Review Material</label>
                        <div class="col-sm-8 custom-file">
                            <input type="file" id="file" name="file" class="form-control-file"value="{{ old('file') }} }}">
                        </div>
                    </div>
                </div>
            </section>
            <section id="upload-progress" class="d-none">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-12 col-sm-12 mb-3 text-center">
                            Please wait while your file is being uploaded
                            <br>
                            This may take a while depending on the video file size.
                            <br>
                            <i class="fas fa-spinner fa-spin fa-3x"></i>
                        </div>
                    </div>
                </div>
            </section>

            <section id="submit-buttons">
                <div class="container-fluid">
                    <div class="form-group row">
                        <div class=" mx-auto mb-3 ">
                            <button class="btn btn-primary ">Cancel</button>
                            <input type="submit" class="btn btn-success " value="Submit"/>
                        </div>
                    </div>
                </div>
            </section>
        </form>


@endsection
@push('scripts')
    <script>
        function showLoading() {
            $('#submit-buttons').addClass('d-none');
            $('#upload-progress').removeClass('d-none');
        }
    </script>
@endpush