@extends('layouts.app')

@section('content')
<div class="col-md-5 col-md-offset-3">
    <form action="{{ route('modules.update', ['module' => $module->id]) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label>Module Name</label>
            <input required class="form-control" type="text" name="name" value="{{ $module->name }}">
            <input type="hidden" name="is_open" value="{{ $module->is_open }}">

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