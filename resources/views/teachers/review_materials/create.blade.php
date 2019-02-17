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

        <form action="{{ route('modules.lessons.review-materials.store', [
            'module' => $lesson->module,
            'lesson' => $lesson,
        ]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <section>
                <div class="row">
                    <div class="col-xl-12 col-sm-12 input-group mb-3">

                        <label class="col-sm-2 col-form-label" class="">Name</label>

                        <div class="col-sm-8">
                            <input required type="text" id="name" name="name" class="form-control"  placeholder="" value="{{ old('name') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-sm-12 input-group mb-3">

                        <label class="col-sm-2 col-form-label" class="">Description</label>

                        <div class="col-sm-8">
                            <textarea rows="2" id="description" name="description" class="form-control"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12 col-sm-12 input-group mb-3">
                        <label class="col-sm-2 col-form-label" class="">Review Material</label>
                        <div class="col-sm-8 custom-file">
                            <input required type="file" id="file" name="file" class="form-control-file" id="inputGroupFile01" value="{{ old('file') }} }}">
                        </div>
                    </div>
                </div>
            </section>
            <section>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-12 col-sm-12 mb-3">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%">Uploading...</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section>
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