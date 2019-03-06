
@extends('layouts.app')

@section('content')
      <div class="container-fluid">

        <!-- Page Content -->
        <h1>{{ $user->full_name }} - Evaluation</h1>

        <hr>

      </div>
      <!-- /.container-fluid -->

    <section>
        <table class="table">
        	<tr>
        		<td>Classification</td>
        		<td>{{ ucwords($user->classification) }}</td>
        	</tr>

        	@foreach ($modules as $module)
        	<tr>
        		<td colspan="2" class="text-center">Yunit {{ $module->order }} - {{ $module->name }}</td>
        	</tr>
        	<tr>
        		<td colspan="2" class="text-center">
        			@php
        				$test = $module->periodicaltest->getUserTests($user)->sortByDesc('score')->first()
        				@endphp
        				@if ($test)
        					<p>Periodical Test - 
	        					@if ($test->isPassed())
	        						<span class="text-success">Passed</span>
	        					@else
	        						<span class="text-danger">Failed</span>
	        					@endif
        					</p>
        				@else
        					<p>Periodical Test - <i>Not yet taken</i></p>
        				@endif
        		</td>
        	</tr>
	        	@foreach($module->lessons as $lesson)
	        	<tr>
	        		
        			<td>Aralin {{ $lesson->order }} - {{ $lesson->name }}</td>
        			<td>
        				@php
        					$test = $lesson->pretest->getUserTests($user)->sortByDesc('score')->first()
        				@endphp
        				@if ($test)
        					<p>Pre Test - 
	        					@if ($test->isPassed())
	        						<span class="text-success">Passed</span>
	        					@else
	        						<span class="text-danger">Failed</span>
	        					@endif
        					</p>
        				@else
        					<p>Pre Test - <i>Not yet taken</i></p>
        				@endif
        				
        				@php
        					$test = $lesson->posttest->getUserTests($user)->sortByDesc('score')->first()
        				@endphp
        				@if ($test)
        					<p>Post Test - 
	        					@if ($test->isPassed())
	        						<span class="text-success">Passed</span>
	        					@else
	        						<span class="text-danger">Failed</span>
	        					@endif
        					</p>
        				@else
        					<p>Post Test - <i>Not yet taken</i></p>
        				@endif
        			</td>
	        	</tr>
	        	@endforeach
        	@endforeach
        </table>
      
    </section>


@endsection

