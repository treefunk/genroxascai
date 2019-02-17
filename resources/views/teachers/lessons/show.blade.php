@extends('layouts.app')

@section('content')
        <div class="container-fluid">

            @include('layouts.partials.breadcrumbs')

            <!-- Page Content -->
            <h4>Lesson #{{ $lesson->order }}</h4>
            <h1>{{ $lesson->name }}</h1>
            <hr>


        </div>
        <!-- /.container-fluid -->

        <!--      <section>
             <div class="container-fluid">
               <div class="row">
                  <div class="col-xl-3 col-sm-6 mb-3">
                    <button class="btn btn-primary">Add Pre-Test</button>
                  </div>
                  <div class="col-xl-3 col-sm-6 mb-3">
                    <button class="btn btn-primary">Add Post-Test</button>
                  </div>
                  <div class="col-xl-3 col-sm-6 mb-3">
                    <button class="btn btn-primary">Add Review Materials</button>
                  </div>
                  <div class="col-xl-3 col-sm-6 mb-3">
                    <button class="btn btn-primary">Add Module</button>
                  </div>
               </div>
             </div>
            </section> -->

        <section>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-3 col-sm-6 mb-3">

                        <div class="card bg-white" style="">
                            <img src="https://via.placeholder.com/350x150" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Pre-Test</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                               <a href="{{ route('pretest',['lesson_id' => $lesson->id,'test_id' => $lesson->pre_test->id]) }}" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="card bg-white" style="">
                            <img src="https://via.placeholder.com/350x150" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Post-Test</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                <a href="{{ route('posttest',['lesson_id' => $lesson->id,'test_id' => $lesson->post_test->id]) }}" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="card bg-white" style="">
                            <img src="https://via.placeholder.com/350x150" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Review Materials</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                <a href="{{ route('modules.lessons.review-materials.index', [
                                    'lesson' => $lesson->id,
                                    'module' => $lesson->module->id,
                                ]) }}" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="card bg-white" style="">
                            <img src="https://via.placeholder.com/350x150" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Drills</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                <a href="#" class="btn btn-primary">View Details</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>


@endsection
