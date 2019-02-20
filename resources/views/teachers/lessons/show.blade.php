@extends('layouts.app')

@section('content')
        <div class="container-fluid">

            @include('layouts.partials.breadcrumbs')

            <!-- Page Content -->
            <h1>{{ $lesson->name }}</h1>
            <h4>Lesson #{{ $lesson->order }}</h4>

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
                <div class="row colored-cards">
                    <div class="col-xl-3 col-sm-6 mb-3">

                        <div class="card bg-white" style="">
                            <img height="300" src="/images/cliparts/pre-test.svg" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Pre-Test</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                               <a href="{{ route('pretest',[
                                'module' => $lesson->module->id,
                                'lesson' => $lesson->id,
                                'test' => $lesson->pretest->id
                                ]) }}" class="btn btn-danger">View</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="card bg-white" style="">
                            <img height="300" src="/images/cliparts/post-test.svg" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Post-Test</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                <a href="{{ route('posttest', [
                                  'module' => $lesson->module->id,
                                  'lesson' => $lesson->id,
                                  'test' => $lesson->posttest->id
                                  ]) }}" class="btn btn-primary">View</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="card bg-white" style="">
                            <img height="300" src="/images/cliparts/review-materials.svg" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Review Materials</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                <a href="{{ route('modules.lessons.review-materials.index', [
                                    'lesson' => $lesson->id,
                                    'module' => $lesson->module->id,
                                ]) }}" class="btn btn-warning">View</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="card bg-white" style="">
                            <img height="300" src="/images/cliparts/drills.svg" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Drills</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                <a href="#" class="btn btn-success">View</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>


@endsection
