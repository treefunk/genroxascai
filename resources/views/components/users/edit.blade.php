@php
use App\User;
use App\Section;
use Illuminate\Support\Facades\Auth;

$isTeacher = $user->is_teacher;
$sections = Section::all();
@endphp

        <div class="container-fluid">
        <form method="post" action="{{ route($route, $routeParams) }}" onsubmit="return confirm('Are you sure?');">
          @csrf
          @method('PATCH')
           <div class="form-group row">
            <label for="firstname" class="col-lg-2 col-sm-12 col-md-3 col-form-label mb-3">First Name</label>
            <div class="col-lg-4 col-md-9 col-sm-12  mb-3">
              <input required type="text" id="firstname" 
                name="firstname" class="form-control" value="{{ $user->firstname }}">
            </div>
            <label for="middlename" class="col-lg-2 col-sm-12 col-md-3 col-form-label mb-3">Middle Name</label>
            <div class="col-lg-4 col-md-9 col-sm-12 mb-3">
              <input required type="text" id="middlename" 
                name="middlename" class="form-control" placeholder="" value="{{ $user->middlename }}">
            </div>
          </div>

         <div class="form-group row">
            <label for="lastname" class="col-lg-2 col-sm-12 col-md-3 col-form-label mb-3">Last Name</label>
            <div class="col-lg-4 col-md-9 col-sm-12  mb-3">
              <input required type="text" id="lastname" 
              name="lastname" class="form-control" value="{{ $user->lastname }}">
            </div>
            <label for="gender" class="col-lg-2 col-sm-12 col-md-3 col-form-label mb-3">Gender</label>
            <div class="col-lg-4 col-md-9 col-sm-12 mb-3">
              <select id="gender" name="gender" class="form-control">
                @if ($user->gender == User::GENDER_MALE)
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
                name="birthdate" class="form-control" value="{{ $user->birthdate }}">
            </div>
            <label for="contact" class="col-lg-2 col-sm-12 col-md-3 col-form-label mb-3">Contact Number</label>
            <div class="col-lg-4 col-md-9 col-sm-12 mb-3">
              <input required type="text" id="contact" 
                name="contact" class="form-control" value="{{ $user->contact }}">
            </div>
          </div>

          <div class="form-group row">
            <label for="address" class="col-lg-2 col-sm-12 col-md-3 col-form-label mb-3">Address</label>
            <div class="col-lg-4 col-md-9 col-sm-12  mb-3">
              <textarea required rows="2" id="address" 
                name="address" class="form-control"  placeholder="">{{ $user->address }}</textarea>
            </div>
            <label for="username" class="col-lg-2 col-sm-12 col-md-3 col-form-label mb-3">Username</label>
            <div class="col-lg-4 col-md-9 col-sm-12 mb-3">
              <input required type="text" id="username" 
                name="username" class="form-control"  placeholder="" value="{{ $user->username }}">
            </div>
          </div>

          <div class="form-group row">
            <label for="password" class="col-lg-2 col-sm-12 col-md-3 col-form-label mb-3">Password</label>
            <div class="col-lg-4 col-md-9 col-sm-12  mb-3">
              <input type="password" id="password" name="password" class="form-control" value="">
            </div>
            <label for="password_confirmation" class="col-lg-2 col-sm-12 col-md-3 col-form-label mb-3">Confirm Password</label>
            <div class="col-lg-4 col-md-9 col-sm-12 mb-3">
              <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"  placeholder="">
            </div>
          </div>

          @if ($isTeacher)
          <div class="form-group row">
            <label for="password" class="col-lg-2 col-sm-12 col-md-3 col-form-label mb-3">Sections</label>
            <div class="col-lg-4 col-md-9 col-sm-12  mb-3">
              @foreach($sections as $section)
                @if ($user->teacher_sections->contains($section->id))
                  <input type="checkbox" id="section_ids" name="section_ids[]" value="{{$section->id}}" checked>
                @else
                  <input type="checkbox" id="section_ids" name="section_ids[]" value="{{$section->id}}" >
                @endif
                 {{ $section->name }} <br>
              @endforeach
            </div>

            <label for="civl_status" class="col-lg-2 col-sm-12 col-md-3 col-form-label mb-3">Civil Status</label>
            <div class="col-lg-4 col-md-9 col-sm-12  mb-3">
              <select class="form-control" name="civil_status" id="civil_status">
                @foreach (User::$civilStatuses as $civilStatus)
                  @if ($user->civil_status === $civilStatus)
                    <option value="{{ $civilStatus }}" selected>{{ ucwords($civilStatus) }}</option>
                  @else
                    <option value="{{ $civilStatus }}">{{ ucwords($civilStatus) }}</option>
                  @endif
                @endforeach
              </select>
            </div>
          </div>
          @endif


          @if (Auth::user()->is_teacher)
          <div class="form-group row">
            <label for="password" class="col-lg-2 col-sm-12 col-md-3 col-form-label mb-3">Section</label>
            <div class="col-lg-4 col-md-9 col-sm-12  mb-3">
              <select class="form-control" name="section_id" id="section_id">
                @foreach ($sections as $section)
                  @if ($user->section_id == $section->id)
                    <option value="{{ $section->id }}" selected>{{ $section->name }}</option>
                  @else
                    <option value="{{ $section->id }}">{{ $section->name }}</option>
                  @endif
                @endforeach
              </select>
            </div>
          </div>
          @endif

          <div class="container-fluid">
            <div class="form-group row">
               <div class=" mx-auto mb-3 ">
                  <button type="reset" class="btn btn-primary" onclick="window.location='{{ url()->previous() }}'">Cancel</button>
                  <input type="submit" class="btn btn-success " value="Submit"/>
               </div>
             </div>
          </div>
        </form>
        </div>