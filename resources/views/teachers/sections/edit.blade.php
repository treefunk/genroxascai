
@extends('layouts.app')

@section('content')
      <div class="container-fluid">

        <!-- Page Content -->
        <h1>Edit Section</h1>
        <hr>

      </div>
      <!-- /.container-fluid -->

    <section>
        <div class="container-fluid">
        <form method="post" action="{{ route('sections.update', ['section' => $section->id]) }}">
          @csrf
          @method('PATCH')
           <div class="form-group row">
            <label for="name" class="col-lg-2 col-sm-12 col-md-3 col-form-label mb-3">Section Name</label>
            <div class="col-lg-4 col-md-9 col-sm-12  mb-3">
              <input required type="text" id="name" 
                name="name" class="form-control" value="{{ $section->name }}">
            </div>
          </div>
          <div class="container-fluid">
            <div class="form-group row">
               <div class=" mx-auto mb-3 ">
                  <button type="reset" class="btn btn-primary" onclick="window.location='{{ url()->previous() }}'">Cancel</button>
                  <input type="submit" class="btn btn-success " value="Submit"/>
               </div>
             </div>
          </div>
        </form>
        </div>
      
    </section>


@endsection

