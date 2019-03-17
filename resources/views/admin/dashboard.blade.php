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
			            <div class="card h-100">
			              <div class="card-header">
			                <h4>{{ $users->count() }} Teachers</h4>
			              </div>
			              <div class="card-body">
			                <div class="card-body-icon">
			                  <i class="fas fa-fw fa-list"></i>
			                </div>
			                <div class="mr-5 mb-2">
			                	<h6>Recent Teachers</h6>
			                </div>
		                	@foreach ($users->sortByDesc('created_at')->take(5) as $user)
		                		{{ $user->firstname }} {{ $user->lastname }} <br>
		                	@endforeach
			              </div>
			            </div>
		          	</div>
				</div>
			</div>	
	</section>

@endsection