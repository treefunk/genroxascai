@extends('layouts.app')

@section('content')
      <div class="container-fluid">
      	@include('layouts.partials.breadcrumbs')
        <!-- Page Content -->
        <h2>
			Welcome {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}!
        </h2>
        <hr>

      </div>
      <!-- /.container-fluid -->

    <section>
	        <div class="container-fluid">

				<div class="row colored-cards">
					<div class="col-xl-3 col-sm-6 mb-3">
			            <div class="card text-white o-hidden h-100">
			              <div class="card-header">
			                <h4>{{ $users->count() }} Students</h4>
			              </div>
			              <div class="card-body">
			                <div class="card-body-icon">
			                  <i class="fas fa-fw fa-list"></i>
			                </div>
			                <div class="mr-5 mb-2">
			                	<h6>Recent Students</h6>
			                </div>
		                	@foreach ($users->sortByDesc('created_at')->take(5) as $user)
		                		{{ $user->firstname }} {{ $user->lastname }} <br>
		                	@endforeach
			              </div>
			            </div>
		          	</div>
					<div class="col-xl-3 col-sm-6 mb-3">
			            <div class="card text-white o-hidden h-100">
			              <div class="card-header">
			                <h4>{{ $modules->count() }} Modules</h4>
			              </div>
			              <div class="card-body">
			                <div class="card-body-icon">
			                  <i class="fas fa-fw fa-list"></i>
			                </div>
		               		<div class="mr-5 mb-2">
			                	<h6>Recent Modules</h6>
			                </div>
		                	@foreach ($modules->sortByDesc('created_at')->take(5) as $module)
		                		{{ $module->name }} <br>
		                	@endforeach
			              </div>
			            </div>
		          	</div>
					<div class="col-xl-3 col-sm-6 mb-3">
			            <div class="card text-white o-hidden h-100">
			              <div class="card-header">
			                <h4>{{ $modules->count() }} Lessons</h4>
			              </div>
			              <div class="card-body">
			                <div class="card-body-icon">
			                  <i class="fas fa-fw fa-list"></i>
			                </div>
		               		<div class="mr-5 mb-2">
			                	<h6>Recent Lessons</h6>
			                </div>
		                	@foreach ($lessons->sortByDesc('created_at')->take(5) as $lesson)
		                		{{ $lesson->name }} <br>
		                	@endforeach
			              </div>
			            </div>
		          	</div>
					<div class="col-xl-3 col-sm-6 mb-3">
			            <div class="card text-white o-hidden h-100">
			              <div class="card-header">
			                <h4>{{ $reviewMaterials->count() }} Review Materials</h4>
			              </div>
			              <div class="card-body">
			                <div class="card-body-icon">
			                  <i class="fas fa-fw fa-list"></i>
			                </div>
		               		<div class="mr-5 mb-2">
			                	<h6>Recent Review Materials</h6>
			                </div>
		                	@foreach ($reviewMaterials->sortByDesc('created_at')->take(5) as $reviewMaterial)
		                		{{ $reviewMaterial->name }} <br>
		                	@endforeach
			              </div>
			            </div>
		          	</div>
				</div>
			</div>	
	</section>

@endsection


@push('scripts')

<script type="text/javascript">
	
	var sound = localStorage.getItem('play_sound');
	if (sound) {
		var audio = new Audio(sound);
		audio.play();
		localStorage.setItem('play_sound', '');
	}
</script>



@endpush