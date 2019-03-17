@extends('layouts.app')

@section('content')
    <div class="col-md-5 col-md-offset-3">
        <form action="{{ route('modules.lessons.update', ['lesson' => $lesson->id, 'module' => $lesson->module->id]) }}" method="POST" onsubmit="return confirm('Are you sure?');">
            @csrf
            @method('PATCH')
            <div class="form-group">
                <label>Name</label>
                <input required class="form-control" type="text" name="name" value="{{ $lesson->name }}">
                <input type="hidden" name="is_open" value="{{ $lesson->is_open }}">
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" id="" cols="30" rows="10" class="form-control" name="description">{{ $lesson->description }}</textarea>
            </div>
            <button type="reset" class="btn btn-light" onclick="window.location='{{ url()->previous() }}'">Cancel</button>
            <button type="submit" class="btn btn-primary">Submit</button>

        </form>

    </div>
@endsection