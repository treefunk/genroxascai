@php
use App\Test;
@endphp

@include('layouts.partials._breadcrumbs-lesson', ['lesson' => $test->lesson])
<li class="breadcrumb-item">
	<a href="{{ route (($test->type === Test::TYPE_PRETEST ? 'pretest' : 'posttest') ,[
	'module' => $test->lesson->module->id,
	'lesson '=> $test->lesson->id,
	'test '=> $test->id,
	]) }}">{{ $test->type_name }}</a>
</li>

