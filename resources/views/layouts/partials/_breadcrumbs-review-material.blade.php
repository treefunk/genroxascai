@include('layouts.partials._breadcrumbs-lesson', ['lesson' => $reviewMaterial->lesson])
<li class="breadcrumb-item">
	<a href="{{ route ('modules.lessons.review-materials.show',[
	'module' => $reviewMaterial->lesson->module,
	'lesson '=> $reviewMaterial->lesson,
	'review_material '=> $reviewMaterial,
	]) }}">{{ $reviewMaterial->name }}</a>
</li>
