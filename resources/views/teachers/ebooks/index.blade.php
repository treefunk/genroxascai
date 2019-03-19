@php
use Illuminate\Support\Facades\Auth;
@endphp
@extends('layouts.app')

@section('content')

    <div class="container-fluid">

        <!-- Breadcrumbs-->
        @include('layouts.partials.breadcrumbs')

        <!-- Page Content -->
        <h1>Ebooks</h1>
        <hr>


    </div>
    <!-- /.container-fluid -->

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 col-sm-6 mb-3">
                    <a href="{{ route('ebooks.create') }}">
                        <button class="btn btn-primary">Add Ebook</button>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid">
            <div class="row colored-cards">
                @foreach ($eBooks as $eBook)
                <div class=" col-xl-3 col-lg-3 col-md-6 col-xs-12 mb-3">
                    <div class="card h-100">
                        <div class="card-header">


<span class="float-right">
  <a class="nav-link p-0  text-right" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="  false">
    <i class="fas fa-fw fa-cog text-light"></i>
  </a>
  <div class="dropdown-menu">
    <a href="{{ route('ebooks.edit', ['ebook' => $eBook->id]) }}" class="p-2">Edit</a>
    @if (Auth::user()->is_admin)
    <form action="{{ route('ebooks.destroy', ['ebook' => $eBook->id]) }}" method="POST"
      onsubmit="return confirm('Are you sure?')">
        @csrf
        @method('DELETE')
      <a href="#" class="p-2" onclick="$(this).closest('form').submit()">
        Delete
      </a>
    </form>
    @endif
  </div>
</span>

                            {{ $eBook->name }}
                        </div>

                        <img src="/images/cliparts/pdf.svg">

                        <div class="card-body">
                            <p class="card-text">{{ $eBook->description }}</p>
                        </div>

                        <div class="card-footer">
                           <a href="{{ route('ebooks.show', ['ebook' => $eBook]) }}">
                                <button class="btn btn-success">View</button>
                            </a>
                             <span class="float-right">
                               <form action="{{ route('ebooks.update', ['ebook' => $eBook]) }}" method="POST">
                                  @csrf
                                  @method('PATCH')
                                  <label class="switch">
                                    <input type="checkbox" 
                                      name="is_open"  
                                        onclick="this.value=this.checked;this.form.submit()" 
                                        {{ $eBook->is_open ? 'checked' : ''}}>
                                    <span class="slider round"></span>
                                  </label>
                                </form>
                            </span>

                        </div>      
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    @endsection