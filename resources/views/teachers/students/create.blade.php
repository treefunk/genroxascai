@php
use App\User;
@endphp

@extends('layouts.app')

@section('content')
      <div class="container-fluid">

        <!-- Page Content -->
        <h1>Add Student</h1>
        <hr>

      </div>
      <!-- /.container-fluid -->

    <section>
        <div class="container-fluid">
        <form method="post" action="{{ route('students.store') }}">
          @csrf
           <div class="form-group row">
            <label for="firstname" class="col-lg-2 col-sm-12 col-md-3 col-form-label mb-3">First Name</label>
            <div class="col-lg-4 col-md-9 col-sm-12  mb-3">
              <input required type="text" id="firstname" 
                name="firstname" class="form-control" value="{{ old('firstname') }}">
            </div>
            <label for="middlename" class="col-lg-2 col-sm-12 col-md-3 col-form-label mb-3">Middle Name</label>
            <div class="col-lg-4 col-md-9 col-sm-12 mb-3">
              <input required type="text" id="middlename" 
                name="middlename" class="form-control" placeholder="" value="{{ old('middlename') }}">
            </div>
          </div>

         <div class="form-group row">
            <label for="lastname" class="col-lg-2 col-sm-12 col-md-3 col-form-label mb-3">Last Name</label>
            <div class="col-lg-4 col-md-9 col-sm-12  mb-3">
              <input required type="text" id="lastname" 
              name="lastname" class="form-control" value="{{ old('lastname') }}">
            </div>
            <label for="gender" class="col-lg-2 col-sm-12 col-md-3 col-form-label mb-3">Gender</label>
            <div class="col-lg-4 col-md-9 col-sm-12 mb-3">
              <select id="gender" name="gender" class="form-control">
                @if (old('gender') == User::GENDER_MALE)
                  <option value="{{ User::GENDER_MALE }}" selected>{{ ucfirst(User::GENDER_MALE) }}</option>
                @else
                  <option value="{{ User::GENDER_MALE }}">{{ ucfirst(User::GENDER_MALE) }}</option>
                @endif
                @if (old('gender') == User::GENDER_FEMALE)
                  <option value="{{ User::GENDER_FEMALE }}" selected>{{ ucfirst(User::GENDER_FEMALE) }}</option>
                @else
                  <option value="{{ User::GENDER_FEMALE }}">{{ ucfirst(User::GENDER_FEMALE) }}</option>
                @endif
              </select>
            </div>
          </div>

          <div class="form-group row">
            <label for="birthdate" class="col-lg-2 col-sm-12 col-md-3 col-form-label mb-3">Birth Date</label>
            <div class="col-lg-4 col-md-9 col-sm-12  mb-3">
              <input required type="date" id="birthdate" 
                name="birthdate" class="form-control" value="{{ old('birthdate') }}">
            </div>
            <label for="contact" class="col-lg-2 col-sm-12 col-md-3 col-form-label mb-3">Contact Number</label>
            <div class="col-lg-4 col-md-9 col-sm-12 mb-3">
              <input required type="text" id="contact" 
                name="contact" class="form-control" value="{{ old('contact') }}">
            </div>
          </div>

          <div class="form-group row">
            <label for="address" class="col-lg-2 col-sm-12 col-md-3 col-form-label mb-3">Address</label>
            <div class="col-lg-4 col-md-9 col-sm-12  mb-3">
              <textarea required rows="2" id="address" 
                name="address" class="form-control"  placeholder="">{{ old('address') }}</textarea>
            </div>
            <label for="email" class="col-lg-2 col-sm-12 col-md-3 col-form-label mb-3">Email</label>
            <div class="col-lg-4 col-md-9 col-sm-12 mb-3">
              <input required type="email" id="email" 
                name="email" class="form-control"  placeholder="" value="{{ old('email') }}">
            </div>
          </div>

          <div class="form-group row">
            <label for="password" class="col-lg-2 col-sm-12 col-md-3 col-form-label mb-3">Password</label>
            <div class="col-lg-4 col-md-9 col-sm-12  mb-3">
              <input required type="text" id="password" name="password" class="form-control" value="">
            </div>
            <label for="password_confirmation" class="col-lg-2 col-sm-12 col-md-3 col-form-label mb-3">Confirm Password</label>
            <div class="col-lg-4 col-md-9 col-sm-12 mb-3">
              <input required type="text" id="password_confirmation" name="password_confirmation" class="form-control"  placeholder="">
            </div>
          </div>
          <div class="container-fluid">
            <div class="form-group row">
               <div class=" mx-auto mb-3 ">
                  <button type="reset" class="btn btn-primary" onclick="window.location='{{ route("students.index") }}'">Cancel</button>
                  <input type="submit" class="btn btn-success " value="Submit"/>
               </div>
             </div>
          </div>
        </div>
    </form>
      
    </section>


@endsection

