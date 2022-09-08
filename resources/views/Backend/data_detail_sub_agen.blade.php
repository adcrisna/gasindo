@extends('layouts.admin')
@section('css')
  <link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
@endsection

@section('content')
    <section class="content-header">
      <ol class="breadcrumb">
        <li><a href="{{ route('home_admin') }}"><i class="fa fa-home"></i> Home</a></li>
        <li><a href="{{ route('data_kota') }}"> Data Kota/Kabupaten</a></li>
      <li> Data Kecamatan</li>
      <li>Data Kelurahann</li>
      <li>Data Customer</li>
      <li class="active">Detail Customer</li>
      </ol>
      <br/>
    </section>
    <section class="content">
    <div class="row">
      <div class="col-xs-12">
          <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">DETAIL DATA Customer</h3>
                <div class="box-tools pull-right">
                <a href="{{ route('data_cust',$detail->id_kelurahan) }}"><button class="btn btn-warning"
                        ><i class="fa fa-sign-out"> Kembali</i></button></a>
              </div>
              <div class="box-body">
        <form action="#" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
        <div class="form-row">
            <div class="col-md-6">
            <div class="form-group has-feedback">
              <label>ID Customer :</label>
              <input type="text"  name="id_cus" class="form-control" value="{{ $detail->id_customer }}"  readonly>
            </div>
            </div>
            <div class="col-md-6">
            <div class="form-group has-feedback">
              <label>Nama Customer :</label>
              <input type="text"  name="nama_agen" class="form-control" value="{{ $detail->nama_customer }}" readonly>
            </div>
            </div>
        </div>
        <div class="form-row">
          <div class="col-md-6">
            <label>Username Customer :</label>
            <input type="text"  name="username" class="form-control" value="{{ $detail->username }}" readonly>
          </div>
          <div class="col-md-6">
          <div class="form-group has-feedback">
            <label>Email Customer :</label>
            <input type="email"  name="email" class="form-control" value="{{ $detail->email_customer }}" readonly>
          </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col-md-6">
          <div class="form-group has-feedback">
            <label>No Telp./WhatsApp :</label>
            <input type="number"  name="no_tlpn" class="form-control" value="{{ $detail->no_hp }}" readonly>
          </div>
          </div>
         <div class="col-md-6">   
          <div class="form-group has-feedback">
            <label>NIK Pemilik Sub Agen :</label>
            <input type="text"  name="nik" class="form-control" value="{{ $detail->nik_customer }}" readonly>
          </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col-md-12">
          <div class="form-group has-feedback">
            <label>Alamat :</label>
            <textarea name="alamat"   class="form-control" readonly> {{ $detail->alamat }}</textarea>
           </div>
         </div>
        <div class="form-row">
          <div class="col-md-4">
          <div class="form-group has-feedback">
              <label for="nama_kec">Kelurahan : </label>
              <input type="text" name="nm_kec" value=" {{ $detail->nama_kelurahan }}" class="form-control" readonly>
          </div>
          </div>
            <div class="col-md-4">
            <div class="form-group has-feedback">
              <label for="nama_kec">Kecamatan :</label>
              <input type="text" name="nm_kec" value=" {{ $detail->nama_kecamatan }}" class="form-control" readonly>
            </div>
            </div>
            <div class="col-md-4">
            <div class="form-group has-feedback">
              <label for="nama_kec">Kota :</label>
              <input type="text" name="nm_kota" value=" {{ $detail->nama_kota }}" class="form-control" readonly>
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
            <input type="text"  name="latitude" id="latitude" class="form-control" value="{{ $detail->latitude }}" readonly>
          </div>
          </div>
          <div class="col-md-6">
          <div class="form-group has-feedback">
            <label>Logitude :</label>
            <input type="text"  name="longitude" id="longitude" class="form-control" value="{{ $detail->longitude }}" readonly>
          </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col-md-4">
          <div class="form-group has-feedback">
            <label>ID LOGIN AGEN :</label>
            <input type="text"  name="id_login" class="form-control" value="{{ $detail->id }}" readonly>
          </div>
          </div>
          <div class="col-md-4">
          <div class="form-group has-feedback">
            <label>Dibuat</label>
            <input type="text" value="{{ $detail->created_at }}"  name="created_at" class="form-control" readonly>
          </div>
          </div>
          <div class="col-md-4">
          <div class="form-group has-feedback">
            <label>Last Updated</label>
            <input type="datepicker" value="{{ $detail->updated_at }}" name="updated_at" class="form-control" readonly>
          </div>
          </div>
        </div>
        </form>
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
<script type="text/javascript">


$('#id_kelurahn').change(function(){
  $('#n_kec').val($(this).find("option:selected").data('nama-kec') );
});
</script>
@endsection