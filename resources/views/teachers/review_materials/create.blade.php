@extends('layouts.app')

@section('content')
    <div id="content-wrapper">

        <div class="container-fluid">

            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.html">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="modules.html">Module 1</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="modules.html">Lessons</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="modules.html">Lesson 1</a>
                </li>
                <li class="breadcrumb-item active">Review Materials</li>

            </ol>

            <!-- Page Content -->
            <h1>Review Materials Page</h1>
            <hr>



        </div>
        <!-- /.container-fluid -->
        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-3 col-sm-6 mb-3">
                        <button class="btn btn-primary">Add Review Material</button>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12 col-sm-12 mb-3">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%">Uploading...</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="container-fluid">
                <div class="form-group row">
                    <div class="col-xl-12 col-sm-12 input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupFileAddon01">Review Material</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12 col-sm-12 input-group mb-3">

                    <label class="col-sm-2 col-form-label" class="">Description</label>

                    <div class="col-sm-8">
                        <textarea rows="2" class="form-control"  placeholder="What is Love?"></textarea>
                    </div>
                </div>
            </div>
        </section>



        <section>
            <div class="container-fluid">
                <div class="form-group row">
                    <div class=" mx-auto mb-3 ">
                        <button class="btn btn-primary ">Cancel</button>
                        <input type="submit" class="btn btn-success " value="Submit"/>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sticky Footer -->
        <footer class="sticky-footer">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright © Your Website 2019</span>
                </div>
            </div>
        </footer>

    </div>
@endsection