<!DOCTYPE html>
<html>
<head><link rel="shortcut icon" href="trustme.png" type="image/x-icon" />
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Register</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/iCheck/square/blue.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/morris/morris.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}">
</head>
<body class="hold-transition register-page">
  <div class="container">
    <div class="register-logo">
    <a href="#"><b>PT. GASINDO CIREBON</b> <BR/> PRIMA</a>
  </div>
<div class="row">
  <div class="col-md-1">
    
  </div>
  <div class="col-md-10">
  <div class="register-box-body">
        @if(\Session::has('msg_gagal_daftar'))
           <h5> <div class="alert alert-danger">
              {{ \Session::get('msg_gagal_daftar')}}
            </div></h5>
            @endif
    <p class="login-box-msg">Register a new membership</p>

    <form action="{{ route('daftar') }}" method="post">
      {{ csrf_field() }}
      <div class="row">
        <div class="col-md-6">
          <div class="form-group has-feedback">
            <input type="text" name="nama_cus" class="form-control" placeholder="Nama Customer" required>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group has-feedback">
            <input type="email" name="email" class="form-control" placeholder="Email Customer" required>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group has-feedback">
            <input type="text" name="nik" class="form-control" placeholder="NIK" required>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group has-feedback">
            <input type="number" name="no_tlpn" class="form-control" placeholder="No Telepon/WhatsApp" required>
            <span class="glyphicon glyphicon-phone form-control-feedback"></span>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group has-feedback">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group has-feedback">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="form-group has-feedback">
            <label>Kota/Kabupaten</label>
            <select class="form-control" name="kota" id="kota" required>
              <option value="">Pilih</option>
              @foreach($kota as $key => $value)
              <option value="{{ $value->id_kota }}">{{ $value->nama_kota }}</option>
              @endforeach
            </select>
            <span class="form-control-feedback"></span>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group has-feedback">
            <label>Kecamatan</label>
            <select class="form-control" name="kecamatan" id="kecamatan" required>
              <option>Pilih</option>
            </select>
            <span class="form-control-feedback"></span>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group has-feedback">
            <label>Kelurahan</label>
            <select class="form-control" name="kelurahan" id="kelurahan" required>
              <option>Pilih</option>
            </select>
            <span class="form-control-feedback"></span>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group has-feedback">
            <label>Detail Alamat :</label>
           <textarea name="alamat" class="form-control" rows="5" cols="20" maxlength="200" required> </textarea>
            <span class="glyphicon glyphicon-home form-control-feedback"></span>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
            <div id="googleMap" style="width:100%;height:380px;"></div>
            <br/>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group has-feedback">
            <label>Latitude :</label>
              <input type="text" id="lat" name="lat" class="form-control" required readonly>
            <span class="glyphicon glyphicon-globe form-control-feedback"></span>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group has-feedback">
            <label>Longitude</label>
              <input type="text" id="lng" name="lng" value="" class="form-control" required readonly>
            <span class="glyphicon glyphicon-globe form-control-feedback"></span>
          </div>
        </div>
      </div>
      <br/>
      <div class="row">
        <div class="col-md-10">
          <div class="checkbox icheck">
            <label>
              <a href="{{ route('index') }}">Kembali</a>
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-md-2">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Daftar</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

        <div class="social-auth-links text-right">
          <p> </p>
        <a href="{{ route('form_login') }}" class="text-center">I already have account </a>
      </div>
    </div>
  </div>
</div>
<script src="{{ asset('plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('plugins/morris/morris.min.js') }}"></script>
<script src="{{ asset('plugins/raphael/raphael-min.js') }}"></script>
<script src="http://maps.googleapis.com/maps/api/js"></script>
<script>
// variabel global marker
var marker;
  
function taruhMarker(peta, posisiTitik){
    
    if( marker ){
      // pindahkan marker
      marker.setPosition(posisiTitik);
    } else {
      // buat marker baru
      marker = new google.maps.Marker({
        position: posisiTitik,
        map: peta
      });
    }
  
     // isi nilai koordinat ke form
    document.getElementById("lat").value = posisiTitik.lat();
    document.getElementById("lng").value = posisiTitik.lng();
    
}
  
function initialize() {
  var propertiPeta = {
    center:new google.maps.LatLng(-6.8326158,108.4039604),
    zoom:9,
    mapTypeId:google.maps.MapTypeId.ROADMAP
  };
  
  var peta = new google.maps.Map(document.getElementById("googleMap"), propertiPeta);
  

  // even listner ketika peta diklik
  google.maps.event.addListener(peta, 'click', function(event) {
    taruhMarker(this, event.latLng);
  });

}

// event jendela di-load  
google.maps.event.addDomListener(window, 'load', initialize);
</script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%'
    });
  });

</script>
<script>
  $(function(){
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

      $('#kota').on('change', function(){
          $.ajax({
            url: '{{ route('kecam') }}',
            method: 'POST',
            data: {id_kota: $(this).val()},
            success: function (response) {
                $('#kecamatan').empty();

                $.each(response, function (id_kecamatan, nama_kecamatan) {
                    $('#kecamatan').append(new Option(nama_kecamatan, id_kecamatan))
                })
            }
        })
      });
      $('#kecamatan').on('change', function(){
          $.ajax({
            url: '{{ route('kelur') }}',
            method: 'POST',
            data: {id_kecamatan: $(this).val()},
            success: function (response) {
                $('#kelurahan').empty();

                $.each(response, function (id_kelurahan, nama_kelurahan) {
                    $('#kelurahan').append(new Option(nama_kelurahan, id_kelurahan))
                })
            }
        })
      });
  });
</script>
</body>
</html>