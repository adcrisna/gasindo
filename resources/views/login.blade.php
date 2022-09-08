<!DOCTYPE html>
<html>
<head><link rel="shortcut icon" href="trustme.png" type="image/x-icon" />
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Selamat Datang</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/iCheck/square/blue.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/morris/morris.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}">
</head>
<body class="hold-transition login-page">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <br/>
          <div class="login-logo">
          <b>PT. GASINDO CIREBON </b> <br> PRIMA <!-- {{bcrypt('luffy977')}} -->
        </div>
      </div>
    </div>
    <div class="row">
    <div class="col-sm-12">
      <div class="login-box">
        <div class="login-box-body">
          <p class="login-box-msg">Sign in to start your session </p>
          <form action="{{ route('login')}}" method="POST">
            {{ csrf_field() }}
            <div class="form-group has-feedback">
              <input type="text" name="username" class="form-control" placeholder="Username" value="{{ old('username') }}">
              <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
              <input type="password" name="password" class="form-control" placeholder="Password">
              <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            @if(\Session::has('msg_login'))
            <div class="alert alert-danger">
              {{ \Session::get('msg_login')}}
            </div>
            @endif
            <div class="row">
              <div class="col-xs-8">
                    <a href="{{ route('index') }}"><i class="fa fa-exit"></i> Kembali</a>
              </div>
              <!-- /.col -->
              <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
              </div>
            </div>
          </form>
          <div class="social-auth-links text-center">
            <p>- OR -</p>
            <a href="{{ route('register') }}" class="text-center">Register a new membership</a>
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
<script src="{{ asset('plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('plugins/morris/morris.min.js') }}"></script>
<script src="{{ asset('plugins/raphael/raphael-min.js') }}"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%'
    });
  });

</script>
</body>
</html>