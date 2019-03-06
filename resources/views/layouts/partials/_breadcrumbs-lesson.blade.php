

@include('layouts.partials._breadcrumbs-module', ['module' => $lesson->module])
<li class="breadcrumb-item">
    Aralin
</li>

<li class="breadcrumb-item">
	<a href="{{ route ('modules.lessons.show',[
	'module' => $lesson->module,
	'lesson '=> $lesson,
	]) }}">{{ $lesson->name }}</a>
</li>


@if (strpos(Route::currentRouteName(), 'review-materials') > -1)
	<li class="breadcrumb-item">
		Review Materials
	</li>
@endif
@if (strpos(Route::currentRouteName(), 'pre-test') > -1)
	<li class="breadcrumb-item">
		Pre Test
	</li>
@endif
@if (strpos(Route::currentRouteName(), 'post-test') > -1)
	<li class="breadcrumb-item">
		Post Test
	</li>
@endif
@if (strpos(Route::currentRouteName(), 'drills') > -1)
	<li class="breadcrumb-item">
		Drills
	</li>
@endif
