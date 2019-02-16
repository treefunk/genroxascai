@extends('layouts.app')

@section('content')
    <div class="col-md-5 col-md-offset-3">
        <form action="{{ route('lessons.store') }}" method="POST">
            <div class="form-group">
                <label>Lesson Name</label>
                <input class="form-control" type="text" name="name">
                <input class="form-control" type="hidden" name="module_id" value="{{$module_id}}">
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" id="" cols="30" rows="10" class="form-control" name="description"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>

        </form>

    </div>
@endsection