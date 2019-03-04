@php
use App\Test;
@endphp

@if ($test->lesson)
	@include('layouts.partials._breadcrumbs-lesson', ['lesson' => $test->lesson])
@endif

@if ($test->module)
	@include('layouts.partials._breadcrumbs-module', ['module' => $test->module])
@endif

@if (strpos(Route::currentRouteName(), 'scores') > -1)
	<li class="breadcrumb-item">
		{{ ucfirst($test->type) }} Scores
	</li>
@else

<li class="breadcrumb-item">

	@switch ($test->type)
		@case(Test::TYPE_PRETEST)
			<a href="{{ route ('pretest' ,[
			'module' => $test->lesson->module->id,
			'lesson '=> $test->lesson->id,
			'test '=> $test->id,
			]) }}">{{ $test->type_name }}</a>
			@break

		@case(Test::TYPE_POSTTEST)
			<a href="{{ route ('posttest' ,[
			'module' => $test->lesson->module->id,
			'lesson '=> $test->lesson->id,
			'test '=> $test->id,
			]) }}">{{ $test->type_name }}</a>
			@break
		@case(Test::TYPE_PERIODICALTEST)
			<a href="{{ route ('periodicaltest' ,[
			'module' => $test->module->id,
			'test '=> $test->id,
			]) }}">{{ $test->type_name }}</a>
			@break
	@endswitch	
</li>

@endif