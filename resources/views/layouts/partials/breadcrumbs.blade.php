@php
use Illuminate\Support\Facades\Route;
$rootRouteName = explode('.', Route::currentRouteName())[0];
@endphp

<!-- Breadcrumbs-->
<ol class="breadcrumb">

    @switch($rootRouteName)
    	@case('modules')
			<li class="breadcrumb-item">
		        <a href="{{ route('modules.index') }}">Modules</a>
		    </li>
	        @break
	    @case('students')
			<li class="breadcrumb-item">
		        <a href="{{ route('students.index') }}">Students</a>
		    </li>
	        @break
	    @default
	@endswitch

    @isset($lesson)
	    <li class="breadcrumb-item">
	        <a href="{{ route ('modules.index') }}">{{ $lesson->module->name }}</a>
	    </li>
	    <li class="breadcrumb-item">
	        <a href="{{ route ('modules.lessons.index',[ 'module'=> $lesson->module ]) }}">Lessons</a>
	    </li>
	    <li class="breadcrumb-item active">{{ $lesson->name }}</li>
	    @endisset
    @isset($module)
	    <li class="breadcrumb-item">
	        <a href="{{ route ('modules.lessons.index', ['module' => $module]) }}">{{ $module->name }}</a>
	    </li>
    @endisset




</ol>