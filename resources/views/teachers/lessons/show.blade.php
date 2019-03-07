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
                        <div class="card h-100" style="">
                            <img height="300" src="/images/cliparts/pre-test.svg" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Pre-Test</h5>
                                <p class="card-text">A preliminary test administered to determine a student's baseline knowledge or preparedness for an educational experience or course of study.</p>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('pretest',[
                                'module' => $lesson->module->id,
                                'lesson' => $lesson->id,
                                'test' => $lesson->pretest->id
                                ]) }}" class="btn btn-warning">View</a>
                                <a href="{{ route('testscores',[
                                    'module' => $lesson->module->id,
                                    'lesson' => $lesson->id,
                                    'test' => $lesson->pretest->id
                                ]) }}" class="btn btn-warning">View Scores</a>
                                <a href="{{ route('test-correct-answers',[
                                    'module' => $lesson->module->id,
                                    'lesson' => $lesson->id,
                                    'test' => $lesson->pretest->id
                                ]) }}" class="btn btn-warning">View Answers</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="card h-100" style="">
                            <img height="300" src="/images/cliparts/review-materials.svg" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Review Materials</h5>
                                <p class="card-text">A recording of moving visual images that show real people, places and things that enable students to learn skills or knowledge.</p>
                                
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('modules.lessons.review-materials.index', [
                                    'lesson' => $lesson->id,
                                    'module' => $lesson->module->id,
                                ]) }}" class="btn btn-info">View</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="card h-100" style="">
                            <img height="300" src="/images/cliparts/drills.svg" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Drills</h5>
                                <p class="card-text ">Play some lesson related games.</p>

                                <div class="card-footer">
                                <a href="{{ route('modules.lessons.drills.index', [
                                    'lesson' => $lesson->id,
                                    'module' => $lesson->module->id,
                                ]) }}" class="btn btn-danger">View</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-sm-6 mb-3">
                        <div class="card h-100" style="">
                            <img height="300" src="/images/cliparts/post-test.svg" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title">Post-Test</h5>
                                <p class="card-text">A test given to students after completion of an instructional program or segment to measure their achievement and the effectiveness of the program.</p>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('posttest', [
                                  'module' => $lesson->module->id,
                                  'lesson' => $lesson->id,
                                  'test' => $lesson->posttest->id
                                  ]) }}" class="btn btn-primary">View</a>
                                  <a href="{{ route('testscores',[
                                    'module' => $lesson->module->id,
                                    'lesson' => $lesson->id,
                                    'test' => $lesson->posttest->id
                                ]) }}" class="btn btn-primary">View Scores</a>
                                <a href="{{ route('test-correct-answers',[
                                    'module' => $lesson->module->id,
                                    'lesson' => $lesson->id,
                                    'test' => $lesson->posttest->id
                                ]) }}" class="btn btn-primary">View Answers</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


@endsection
