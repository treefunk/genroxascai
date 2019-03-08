
@extends('layouts.app')

@section('content')
      <div class="container-fluid">

        <!-- Page Content -->
        <h1>Edit Student</h1>
        <hr>

      </div>
      <!-- /.container-fluid -->

    <section>
        @include('components.users.edit', ['route' => 'students.update', 'routeParams' => ['student' => $user]])
      
    </section>


@endsection

