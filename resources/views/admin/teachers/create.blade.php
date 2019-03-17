
@extends('layouts.app')

@section('content')
      <div class="container-fluid">

        <!-- Page Content -->
        <h1>Add Teacher</h1>
        <hr>

      </div>
      <!-- /.container-fluid -->

    <section>
        @include('components.users.create', ['route' => 'teachers.store', 'routeParams' => ['is_teacher' => true]])
      
    </section>


@endsection

