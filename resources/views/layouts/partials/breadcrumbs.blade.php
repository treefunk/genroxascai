@php
use Illuminate\Support\Facades\Route;
$rootRouteName = explode('.', Route::currentRouteName())[0];
@endphp

<!-- Breadcrumbs-->
<ol class="breadcrumb">

    @switch($rootRouteName)
    	@case('modules')
			<li class="breadcrumb-item">
		        <a href="{{ route('modules.index') }}">Yunit</a>
		    </li>
	        @break
	    @case('pretest')
			<li class="breadcrumb-item">
		        <a href="{{ route('modules.index') }}">Yunit</a>
		    </li>
	        @break
	    @case('posttest')
			<li class="breadcrumb-item">
		        <a href="{{ route('modules.index') }}">Yunit</a>
		    </li>
	        @break
	    @case('periodicaltest')
			<li class="breadcrumb-item">
		        <a href="{{ route('modules.index') }}">Yunit</a>
		    </li>
	        @break
		@case('testscores')
			<li class="breadcrumb-item">
				<a href="{{ route('modules.index') }}">Yunit</a>
			</li>
			@break
	    @case('students')
			<li class="breadcrumb-item">
		        <a href="{{ route('students.index') }}">Students</a>
		    </li>
	        @break
	    @case('sections')
			<li class="breadcrumb-item">
		        <a href="{{ route('sections.index') }}">Sections</a>
		    </li>
	        @break
	    @case('classifications')
			<li class="breadcrumb-item">
		        <a href="{{ route('classifications.index') }}">Classifications</a>
		    </li>
	        @break
	    @case('attendances')
			<li class="breadcrumb-item">
		        <a href="{{ route('attendances.index') }}">Attendance</a>
		    </li>
	        @break
	    @case('analysis')
			<li class="breadcrumb-item">
		        <a href="{{ route('analysis.index') }}">Analysis</a>
		    </li>
	        @break
	    @case('gallery')
			<li class="breadcrumb-item">
		        <a href="{{ route('gallery.index') }}">Gallery</a>
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
