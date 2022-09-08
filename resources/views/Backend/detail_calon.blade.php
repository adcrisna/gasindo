@extends('layouts.admin')
@section('css')
  <link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <section class="content-header">
      <ol class="breadcrumb">
        <li><a href="{{ route('home_admin') }}"><i class="fa fa-home"></i> Home</a></li>
      <li>Data Customer</li>
      <li class="active">Detail Calon Customer</li>
      </ol>
      <br/>
    </section>
    <section class="content">
    <div class="row">
      <div class="col-xs-12">
          <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Detail Calon Customer</h3>
                <div class="box-tools pull-right">
                <a href="{{ route('data_cus') }}"><button class="btn btn-warning"
                        ><i class="fa fa-sign-out"> Kembali</i></button></a>
              </div>
              <div class="box-body">
        <form action="{{ route('aktif_calon') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
        <div class="form-row">
          <div class="col-md-6">
          <div class="form-group has-feedback">
            <label>ID Customer :</label>
            <input type="text"  name="id_cus" class="form-control" value="{{ $edit->id_customer }}"  readonly>
          </div>
          </div>
         <div class="col-md-6">
         <div class="form-group has-feedback">
            <label>Nama Customer :</label>
            <input type="text"  name="nama_cus" class="form-control" value="{{ $edit->nama_customer }}" readonly="">
          </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col-md-6">
          <div class="form-group has-feedback">
              <label>No Telp./WhatsApp :</label>
              <input type="number"  name="no_tlpn" class="form-control" value="{{ $edit->no_hp }}" readonly>
          </div>
          </div>
          <div class="col-md-6">
          <div class="form-group has-feedback">
            <label>Email Sub Agen :</label>
            <input type="email"  name="email" class="form-control" value="{{ $edit->email_customer }}" readonly>
          </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col-md-6">
          <div class="form-group has-feedback">
            <label>Username Sub Agen :</label>
            <input type="text"  name="username" class="form-control" value="{{ $edit->username }}" readonly>
          </div>
          </div>
          <div class="col-md-6">
          <div class="form-group has-feedback">
            <label>Password Sub Agen :</label>
            <input type="password" name="password" class="form-control" placeholder="Masukan Password Baru" readonly>
          </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col-md-6">
          <div class="form-group has-feedback">
            <label>NIK Pemilik Sub Agen :</label>
            <input type="text"  name="nik" class="form-control" value="{{ $edit->nik_customer }}" readonly>
          </div>
          </div>
          <div class="col-md-6">
            <label>Status Login</label>
            <select class="form-control" name="status" id="status">
              <option value="Aktif" <?php if ($edit->status == "Aktif") {
                echo "selected";
              } ?>>Aktif</option>
              <option value="Tidak Aktif" <?php if ($edit->status == "Tidak Aktif") {
                echo "selected";
              } ?>>Tidak Aktif</option>
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="col-md-12">
          <div class="form-group has-feedback">
            <label>Alamat :</label>
           <textarea name="alamat"   class="form-control" readonly> {{ $edit->alamat }}</textarea>
         </div>
         </div>
        </div>
        <div class="form-row">
          <div class="col-md-4">
          <div class="form-group has-feedback">
            <label>Kota/Kabupaten</label>
            <select class="form-control" name="kota" id="kota" disabled>
              @foreach($kota as $key => $value)
              <option value="{{ $value->id_kota }}" <?php if ($value->id_kota == $edit->id_kota) {
                echo "selected";
              } ?>>{{ $value->nama_kota }}</option>
              @endforeach
            </select>
            <span class="form-control-feedback"></span>
          </div>
          </div>
          <div class="col-md-4">
          <div class="form-group has-feedback">
            <label>Kecamatan</label>
            <select class="form-control" name="kecamatan" id="kecamatan" disabled>
              @foreach($kec as $key => $value)
              <option value="{{ $value->id_kecamatan }}" <?php if ($value->id_kecamatan == $edit->id_kecamatan) {
                echo "selected";
              } ?>>{{ $value->nama_kecamatan }}</option>
              @endforeach
            </select>
            <span class="form-control-feedback"></span>
          </div>
          </div>
          <div class="col-md-4">
          <div class="form-group has-feedback">
            <label>Kelurahan</label>
            <input type="text" name="kelurahan" value="{{ $edit->id_kelurahan }}" class="form-control" readonly>
            <span class="form-control-feedback"></span>
          </div>
        </div>
        </div>
          <div class="form-row">
            <div class="col-md-12">
              <div id="gMap" style="width:100%;height:400px;"></div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-6">
            <div class="form-group has-feedback">
              <label>Latitude :</label>
              <input type="text"  name="latitude" id="latitude" class="form-control" value="{{ $edit->latitude }}" readonly>
            </div>
            </div>
            <div class="col-md-6">
            <div class="form-group has-feedback">
              <label>Logitude :</label>
              <input type="text"  name="longitude" id="longitude" class="form-control" value="{{ $edit->longitude }}" readonly>
            </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-4">
            <div class="form-group has-feedback">
              <label>ID LOGIN AGEN :</label>
              <input type="text"  name="id_login" class="form-control" value="{{ $edit->id }}" readonly>
            </div>
            </div>
            <div class="col-md-4">
            <div class="form-group has-feedback">
            <label>Created At :</label>
              <input type="text" value="{{ $edit->created_at }}"  name="created_at" class="form-control" readonly>
            </div>
            </div>
            <div class="col-md-4">
            <div class="form-group has-feedback">
              <label>Last Updated :</label>
              <input type="datepicker" value="{{ $edit->updated_at }}" name="updated_at" class="form-control" readonly>
            </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-2 col-xs-offset-5">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Aktifkan</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
</section>
  @endsection

@section('javascript')
<script src="http://maps.googleapis.com/maps/api/js"></script>
<script>
    function lihatmarker(){
     var lati = parseFloat(document.getElementById("latitude").value) ;
      var long = parseFloat(document.getElementById("longitude").value) ;
    console.log(lati,long);
     var info_window = new google.maps.InfoWindow();

     // menentukan level zoom
     var zoom = 16;

     // menentikan latitude dan longitude
     var pos = new google.maps.LatLng({lat: lati, lng: long});

     // menentukan opsi peta
     var options = {
      'center': pos,
      'zoom': zoom,
      'mapTypeId': google.maps.MapTypeId.ROADMAP
     };

     // membuat peta
     var map = new google.maps.Map(document.getElementById('gMap'), options);
     info_window = new google.maps.InfoWindow({
      'content': 'loading...'
     });

     // membuat marker
     var marker = new google.maps.Marker({
      position: pos,
      title: 'here',
      
     });

     // set marker di peta
     marker.setMap(map);

     // membuat event ketika marker di click
     google.maps.event.addListener(marker, 'click', function(){
      info_window.setContent('<b>'+ this.title +'</b>');
      info_window.open(map, this);
     });
    }
    google.maps.event.addDomListener(window, 'load', lihatmarker);
</script>
<script>
  $(function(){
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

      $('#kota').on('change', function(){
          $.ajax({
            url: '{{ route('keca') }}',
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
            url: '{{ route('kelu') }}',
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
</script>
@endsection