@php
use Illuminate\Support\Facades\Auth;
@endphp
<nav class="navbar navbar-expand navbar-dark bg-dark static-top">



    <!-- Sidenav Dropdown -->
    <ul class="navbar-nav ml-auto ml-md-0">
      <li class="nav-item dropdown">
        <a class="nav-link navbar-brand dropdown-toggle" href="dashboard" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         <i class="fas fa-bars"></i>
            @if (Auth::user()->is_teacher)
              Teacher's Panel
            @elseif (Auth::user()->is_admin)
              Admin's Panel
            @endif
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a>
          @if (Auth::user()->is_teacher)
            <a class="dropdown-item" href="{{ route('modules.index') }}">Yunit</a>
            <a class="dropdown-item" href="{{ route('students.index') }}">Students</a>
            <a class="dropdown-item" href="{{ route('sections.index') }}">Sections</a>
            <a class="dropdown-item" href="{{ route('classifications.index') }}">Classifications</a>
            <a class="dropdown-item" href="{{ route('attendances.index') }}">Attendances</a>
            <a class="dropdown-item" href="{{ route('analysis.index') }}">Student Evaluation</a>
          @elseif (Auth::user()->is_admin)
            <a class="dropdown-item" href="{{ route('teachers.index') }}">Teachers</a>
          @endif
          <a class="dropdown-item" href="{{ route('ebooks.index') }}">Ebooks</a>
        </div>
      </li>
    </ul>

    <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
    </div>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
         <i class="fas fa-fw fa-user"></i>
          {{ Auth::user()->firstname }}  {{ Auth::user()->lastname }}
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="/settings/profile">Settings</a>
          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
        </div>
      </li>
    </ul>

    
  </nav>

