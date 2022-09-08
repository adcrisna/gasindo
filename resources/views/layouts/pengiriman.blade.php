<!DOCTYPE html>
<html>
<head>
  <link rel="shortcut icon" href="{{ asset('ucic.png') }}" type="image/x-icon" />
	<meta charset="utf-8">
  	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>{{ $title }}</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" type="text/css" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/ionslider/ion.rangeSlider.min.js') }}">
  <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css') }}">
  @yield('css')
</head>
	<body class="hold-transition skin-red sidebar-mini">
		<div class="wrapper">

  <header class="main-header">
    <a href="{{ route('home_penjualan') }}" class="logo">
      <span class="logo-mini"><b>GAS</b></span>
      <span class="logo-lg"><b>Pengiriman</b></span>
    </a>
    <nav class="navbar navbar-static-top">
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Navigation</span>
      </a>
    </nav>
  </header>
  <aside class="main-sidebar control-sidebar-dark">
    <div class="user-panel">
        <!-- <div class="pull-left image">
          <img src="{{ asset('ucic.png') }}" class="img-circle" alt="User Image">
        </div> -->
        <!-- <div class="pull-left info">
          <p>{{ $nama }}</p>
          <a href="{{ route('home_penjualan') }}"><i class="fa fa-circle text-success"></i> Online</a>
        </div> -->
        
      </div>
    <section class="sidebar">      
      <ul class="sidebar-menu">
        <li>
          <a href="{{ route('home_penjualan') }}">
            <i class="fa fa-home"></i> <span>Home</span>
          </a>
        </li>
        <li>
          <a href="{{ route('data_pengiriman') }}">
            <i class="fa fa-book"></i> <span>Data Pengiriman</span>
          </a>
        </li>
        <li>
          <a href="{{ route('logout_penjualan') }}">
            <i class="fa fa-sign-out"></i> <span>Logout</span>
          </a>
        </li>
      </ul>
    </section>
  </aside>
  <div class="content-wrapper">
    @yield('content')
  </div>
    <footer class="main-footer">
      <div class="pull-right hidden-xs">
        <b>Build with <span class="fa fa-coffee"></span> And <span class="fa fa-heart"></b>
      </div>
      <strong>@adcrisna_ &copy; 2021</strong>
    </footer>
  <div class="control-sidebar-bg"></div>
</div>
<script src="{{ asset('plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
<script src="{{ asset('plugins/jQueryUI/jquery-ui.min.js') }}"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('plugins/fastclick/fastclick.js') }}"></script>
<script src="{{ asset('dist/js/app.min.js') }}"></script>
<script src="{{ asset('dist/js/demo.js') }}"></script>
@yield('javascript')
</body>
</html>