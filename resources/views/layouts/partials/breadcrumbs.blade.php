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
		@case('testscores')
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
	    	<li class="breadcrumb-item">
		        <a href="{{ route('dashboard') }}">Dashboard</a>
		    </li>
	@endswitch


    @isset($lesson)
    	@include('layouts.partials._breadcrumbs-lesson', ['lesson' => $lesson])
	  @endisset
    @isset($module)
    	@include('layouts.partials._breadcrumbs-module', ['module' => $module])
    @endisset

    @isset($reviewMaterial)
   		@include('layouts.partials._breadcrumbs-review-material')
    @endisset
    @isset($test)
   		@include('layouts.partials._breadcrumbs-test')
    @endisset





</ol>
