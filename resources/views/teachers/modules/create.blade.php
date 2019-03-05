@extends('layouts.app')

@section('content')
<div class="col-md-5 col-md-offset-3">
    <form action="{{ route('modules.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Module Name</label>
            <input required class="form-control" type="text" name="name" value="{{ old('name') }}">

        </div>

        <div class="row">
            <div class="col-xl-12 col-sm-12 input-group mb-3">
                <label class="col-sm-2 col-form-label" class="">Thumbnail (optional)</label>
                <div class="col-sm-8 custom-file">
                    <input type="file" id="file" name="file" class="form-control-file" value="{{ old('file') }} }}">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea id="" cols="30" rows="10" class="form-control" name="description">{{ old('description') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>

    </form>

</div>
@endsection