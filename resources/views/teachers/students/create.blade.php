@extends('layouts.app')

@section('content')
    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Page Content -->
        <h1>Add Student</h1>
        <hr>

      </div>
      <!-- /.container-fluid -->

    <section>
      <div class="container-fluid">

           
           <div class="form-group row">
            <label for="staticEmail" class="col-lg-2 col-sm-12 col-md-3 col-form-label mb-3">First Name</label>
            <div class="col-lg-4 col-md-9 col-sm-12  mb-3">
              <input type="text"  class="form-control" value="">
            </div>
            <label for="inputPassword" class="col-lg-2 col-sm-12 col-md-3 col-form-label mb-3">Middle Name</label>
            <div class="col-lg-4 col-md-9 col-sm-12 mb-3">
              <input type="text" class="form-control"  placeholder="">
            </div>
          </div>

         <div class="form-group row">
            <label for="staticEmail" class="col-lg-2 col-sm-12 col-md-3 col-form-label mb-3">Last Name</label>
            <div class="col-lg-4 col-md-9 col-sm-12  mb-3">
              <input type="text"  class="form-control" value="">
            </div>
            <label for="inputPassword" class="col-lg-2 col-sm-12 col-md-3 col-form-label mb-3">Gender</label>
            <div class="col-lg-4 col-md-9 col-sm-12 mb-3">
              <input type="text" class="form-control"  placeholder="">
            </div>
          </div>

          <div class="form-group row">
            <label for="staticEmail" class="col-lg-2 col-sm-12 col-md-3 col-form-label mb-3">Birth Date</label>
            <div class="col-lg-4 col-md-9 col-sm-12  mb-3">
              <input type="text"  class="form-control" value="">
            </div>
            <label for="inputPassword" class="col-lg-2 col-sm-12 col-md-3 col-form-label mb-3">Contact Number</label>
            <div class="col-lg-4 col-md-9 col-sm-12 mb-3">
              <input type="text" class="form-control"  placeholder="">
            </div>
          </div>

          <div class="form-group row">
            <label for="staticEmail" class="col-lg-2 col-sm-12 col-md-3 col-form-label mb-3">Address</label>
            <div class="col-lg-4 col-md-9 col-sm-12  mb-3">
              <textarea rows="2" class="form-control"  placeholder="What is Love?"></textarea>
            </div>
            <label for="inputPassword" class="col-lg-2 col-sm-12 col-md-3 col-form-label mb-3">Username</label>
            <div class="col-lg-4 col-md-9 col-sm-12 mb-3">
              <input type="text" class="form-control"  placeholder="">
            </div>
          </div>

          <div class="form-group row">
            <label for="staticEmail" class="col-lg-2 col-sm-12 col-md-3 col-form-label mb-3">Password</label>
            <div class="col-lg-4 col-md-9 col-sm-12  mb-3">
              <input type="text"  class="form-control" value="">
            </div>
            <label for="inputPassword" class="col-lg-2 col-sm-12 col-md-3 col-form-label mb-3">Confirm Password</label>
            <div class="col-lg-4 col-md-9 col-sm-12 mb-3">
              <input type="text" class="form-control"  placeholder="">
            </div>
          </div>

        </div>
      
    </section>

    <section>
       <div class="container-fluid">
        <div class="form-group row">
           <div class=" mx-auto mb-3 ">
              <button class="btn btn-primary ">Cancel</button>
              <input type="submit" class="btn btn-success " value="Submit"/>
           </div>
         </div>
       </div>
    </section>

    </div>
    <!-- /.content-wrapper -->

@endsection

