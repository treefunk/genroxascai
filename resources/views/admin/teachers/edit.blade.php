
@extends('layouts.app')

@section('content')
      <div class="container-fluid">

        <!-- Page Content -->
        <h1>Edit Teacher</h1>
        <hr>

      </div>
      <!-- /.container-fluid -->

    <section>
        @include('components.users.edit', ['route' => 'teachers.update', 'routeParams' => ['teacher' => $user]])
      
    </section>


@endsection

