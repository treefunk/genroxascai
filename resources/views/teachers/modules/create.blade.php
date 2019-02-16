@extends('layouts.app')

@section('content')
<div class="col-md-5 col-md-offset-3">
    <form action="{{ route('modules.store') }}" method="POST">
        <div class="form-group">
            <label>Module Name</label>
            <input class="form-control" name="name">
        </div>
        
        <div class="form-group">
            <label>Description</label>
            <textarea name="" id="" cols="30" rows="10" class="form-control" name="description"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        
    </form>

</div>
@endsection