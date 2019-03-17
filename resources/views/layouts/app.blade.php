<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name') }}</title>

  <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ url('css/datatables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ url('css/sb-admin.min.css') }}">
  <link rel="stylesheet" href="{{ url('css/appbackend.css') }}">
</head>
<body id="page-top">
  @include('layouts.partials.top-nav')
  <div id="wrapper">
    <div id="content-wrapper">
      @include('layouts.partials.flash')
      @yield('content')
      @include('layouts.partials.footer')
    </div>
  </div>
  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="javascript:void(0)" onclick="logout()">Logout</a>
        </div>
      </div>
    </div>
  </div>


  @if (app()->isLocal())
  @else
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
  @endif
  <script src="/js/jquery.min.js"></script>
  <script src="{{ mix('js/appbackend.js') }}"></script>
  <script src="/js/jquery.easing.min.js"></script>
  <script src="{{ url('js/sb-admin.min.js') }}"></script>
  <script src="{{ url('js/jquery.datatables.min.js') }}"></script>
  <script src="{{ url('js/chart.min.js') }}"></script>
  <script type="text/javascript">
    $(document).ready( function () {
      $('#dataTable').DataTable();
    });
    function logout() {
      localStorage.setItem('play_sound', '/sounds/logout.wav');
      clearCookies();
      clearCookies();
      clearCookies();
      window.location='/login';
    }

    function clearCookies() {
      var res = document.cookie;
      var multiple = res.split(";");
      for(var i = 0; i < multiple.length; i++) {
          var key = multiple[i].split("=");
          document.cookie = key[0]+" =; expires = Thu, 01 Jan 1970 00:00:00 UTC";
      }
    }
  </script>

  <script type="text/javascript">
    var sound = localStorage.getItem('play_sound');
    if (sound) {
      var audio = new Audio(sound);
      audio.play();
      localStorage.setItem('play_sound', '');
    }
  </script>
  @stack('scripts')
</body>
</html>
