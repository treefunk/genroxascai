@extends('layouts.app')

@section('content')
    <div class="col-md-5 col-md-offset-3">
        <form action="{{ route('modules.lessons.store', ['module' => $module]) }}" method="POST" onsubmit="return confirm('Are you sure?');">
            @csrf
            <div class="form-group">
                <label>Name</label>
                <input required class="form-control" type="text" name="name" value="{{ old('name') }}">
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" id="" cols="30" rows="10" class="form-control" name="description">{{ old('description') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>

        </form>

    </div>
@endsection