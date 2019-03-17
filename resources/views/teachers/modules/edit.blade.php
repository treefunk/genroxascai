@extends('layouts.app')

@section('content')
<div class="col-md-5 col-md-offset-3">
    <form action="{{ route('modules.update', ['module' => $module->id]) }}" method="POST" enctype="multipart/form-data" onsubmit="return confirm('Are you sure?');">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label>Name</label>
            <input required class="form-control" type="text" name="name" value="{{ $module->name }}">
            <input type="hidden" name="is_open" value="{{ $module->is_open }}">

        </div>

        <div class="row">
            <div class="col-xl-12 col-sm-12 input-group mb-3">
                <label class="col-sm-2 col-form-label" class="">Thumbnail (optional)</label>
                <div class="col-sm-8 custom-file">
                    <input type="file" id="file" name="file" class="form-control-file"value="{{ old('file') }} }}">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea id="" cols="30" rows="10" class="form-control" name="description">{{ $module->description }}</textarea>
        </div>
        <button type="reset" class="btn btn-light" onclick="window.location='{{ url()->previous() }}'">Cancel</button>
        <button type="submit" class="btn btn-primary">Submit</button>

    </form>

</div>
@endsection