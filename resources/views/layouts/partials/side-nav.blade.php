@php
use Illuminate\Support\Facades\Auth;
@endphp

@if (Auth::user()->is_teacher)
<ul class="sidebar navbar-nav">
  <li class="nav-item">
    <a class="nav-link" href="{{ route('dashboard') }}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span>
    </a>
  </li>
  <li class="nav-item dropdown">
    {{-- <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fas fa-fw fa-folder"></i>
      <span>Modules</span>
    </a> --}}
    {{-- <div class="dropdown-menu" aria-labelledby="pagesDropdown">
      <h6 class="dropdown-header">Login Screens:</h6>
      <a class="dropdown-item" href="login.html">Login</a>
      <a class="dropdown-item" href="register.html">Register</a>
      <a class="dropdown-item" href="forgot-password.html">Forgot Password</a>
      <div class="dropdown-divider"></div>
      <h6 class="dropdown-header">Other Pages:</h6>
      <a class="dropdown-item" href="404.html">404 Page</a>
      <a class="dropdown-item active" href="blank.html">Blank Page</a>
    </div> --}}
  <li class="nav-item">
      <a class="nav-link" href="{{ route('modules.index') }}">
      <i class="fas fa-fw fa-table"></i>
      <span>Yunit</span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('students.index') }}">
      <i class="fas fa-fw fa-users"></i>
      <span>Students</span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('sections.index') }}">
      <i class="fas fa-fw fa-address-card"></i>
      <span>Sections</span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('classifications.index') }}">
      <i class="fas fa-fw fa-star"></i>
      <span>Classifications</span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('attendances.index') }}">
      <i class="fas fa-fw fa-list"></i>
      <span>Attendance</span></a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="{{ route('analysis.index') }}">
      <i class="fas fa-fw fa-chart-pie"></i>
      <span>Analysis</span></a>
  </li>
</ul>
@elseif (Auth::user()->is_admin)
<ul class="sidebar navbar-nav">
  <li class="nav-item">
    <a class="nav-link" href="{{ route('dashboard') }}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span>
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('teachers.index') }}">
      <i class="fas fa-fw fa-users"></i>
      <span>Teachers</span></a>
  </li>
</ul>
@endif