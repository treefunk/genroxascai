@extends('layouts.app')

@section('content')

    <div class="container-fluid">

        <!-- Breadcrumbs-->
        @include('layouts.partials.breadcrumbs')

        <!-- Page Content -->
        <h1>{{ $eBook->name }}</h1>
        <hr>


    </div>
    <!-- /.container-fluid -->

    <section style="height: 100%;">
        <div class="row" style="height: 100%;">
            <div class="col-12" style="height: 100%;">
                @if ($eBook->mime_type === 'application/pdf')
                <embed src="/storage/ebooks/{{ $eBook->file_name }}" width="100%" height="800" 
 type="application/pdf">

                @endif
            </div>
        </div>
    </section>

    @endsection