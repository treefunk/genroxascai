@extends('layouts.app')

@section('content')

    <div class="container-fluid">

        @include('layouts.partials.breadcrumbs')

        <h1>Sections</h1>
        <hr>

        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-3 col-sm-6 mb-3">
                        <button class="btn btn-primary" onclick="window.location='{{ route("sections.create") }}'">Add Section</button>
                    </div>
                </div>
            </div>
        </section>

        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-table"></i>
                Students</div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Name</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>Name</th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @foreach ($sections as $section)
                            <tr>
                                <td>{{ $section->name }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

@endsection

