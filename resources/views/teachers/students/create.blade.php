
@extends('layouts.app')

@section('content')
      <div class="container-fluid">

        <!-- Page Content -->
        <h1>Add Student</h1>
        <hr>

      </div>
      <!-- /.container-fluid -->

    <section>
        @include('components.users.create', ['route' => 'students.store'])
      
    </section>


@endsection

