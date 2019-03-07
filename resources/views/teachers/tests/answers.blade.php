@extends('layouts.app')

@section('content')

        <div class="container-fluid">
                @include('layouts.partials.breadcrumbs')
                <h1>{{ $test->type_name }} Answers</h1>

                <div class="accordion" id="accordionExample">
                        <div class="card">
                          <div class="card-header" id="answer-key">
                            <h2 class="mb-0">
                              <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Answer Keys
                              </button>
                            </h2>
                          </div>
                      
                          <div id="collapseOne" class="collapse" aria-labelledby="answer-key" data-parent="#accordionExample">
                            <div class="card-body">
                                    @foreach($testAnswers as $num => $question)
                                    <p>
                                        {{ $num + 1 }}.
                                        @foreach($question->choices as $num => $choice)
                                            @php if(!$choice->is_correct){ continue; } @endphp
                                            {{ $num + 1 }}
                                        @endforeach
                                    </p>
                                    @endforeach
                    
                            </div>
                          </div>
                        </div>
                        <div class="card">
                          <div class="card-header" id="questions-and-answers">
                            <h2 class="mb-0">
                              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Question and Answers
                              </button>
                            </h2>
                          </div>
                          <div id="collapseTwo" class="collapse" aria-labelledby="questions-and-answers" data-parent="#accordionExample">
                            <div class="card-body">
                                    @foreach($testAnswers as $num => $question)
                                    <div class="card">
                                        <div class="card-header">
                                        <strong>#{{ $num + 1 }}</strong>  Question: {{ $question->text }}
                                        </div>
                                        <div class="card-body">
                                                <ul class="list-group">
                                                    @foreach($question->choices as $choice_num => $choice)
                                                        <li class="list-group-item {{ $choice->is_correct ? "list-group-item-success" : ""}}">#{{ $choice_num + 1 }} {{ $choice->text }}</li>
                                                    @endforeach
                                                </ul>
                                        </div>
                                      </div>
                                @endforeach
                            </div>
                          </div>
                        </div>
                </div>


                
            </div>
            <!-- /.container-fluid -->
        </div>
@endsection
