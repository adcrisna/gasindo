@extends('layouts.customer')
@section('css')

@endsection

@section('content')
      <section class="content-header">
       
        <ol class="breadcrumb">
          <li><a href="{{ route('home_customer') }}"><i class="fa fa-gear"></i> Profile</a></li>
        </ol>
      </section>
      <br/>
       @if(\Session::has('msg_edit_cus'))
           <h5> <div class="alert alert-warning">
              {{ \Session::get('msg_edit_cus')}}
            </div></h5>
            @endif
      <br/>
      <!-- Main content -->
      <section class="content">
      <div class="row">
      <div class="col-xs-12">
          <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Profile</h3>
                <div class="box-tools pull-right">
                <a href="{{ route('home_customer') }}"><button class="btn btn-warning"
                        ><i class="fa fa-sign-out"> Kembali</i></button></a>
              </div>
          <div class="box-body">
        <form action="{{ route('update_profile') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
        <div class="form-row">
          <div class="col-md-6">
          <div class="form-group has-feedback">
            <input type="hidden"  name="id_cus" class="form-control" value="{{ $edit->id_customer }}"  readonly>
            <label>Nama Customer :</label>
            <input type="text"  name="nama_cus" class="form-control" value="{{ $edit->nama_customer }}" required>
          </div>
          </div>
         <div class="col-md-6">
         <div class="form-group has-feedback">
              <label>No Telp./WhatsApp :</label>
              <input type="number"  name="no_tlpn" class="form-control" value="{{ $edit->no_hp }}" required>
          </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col-md-6">
          <div class="form-group has-feedback">
            <label>Email Customer :</label>
            <input type="email"  name="email" class="form-control" value="{{ $edit->email_customer }}" required>
          </div>
          </div>
          <div class="col-md-6">
          <div class="form-group has-feedback">
            <label>NIK Pemilik Customer :</label>
            <input type="text"  name="nik" class="form-control" value="{{ $edit->nik_customer }}" required>
          </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col-md-6">
          <div class="form-group has-feedback">
            <label>Username Customer :</label>
            <input type="text"  name="username" class="form-control" value="{{ $edit->username }}" readonly>
          </div>
          </div>
          <div class="col-md-6">
          <div class="form-group has-feedback">
            <label>Password Customer :</label>
            <input type="password" name="password" class="form-control" placeholder="Masukan Password Baru" >
          </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col-md-12">
          <div class="form-group has-feedback">
            <label>Alamat :</label>
           <textarea name="alamat"   class="form-control" required>{{ $edit->alamat }} </textarea>
         </div>
         </div>
        </div>
        <div class="form-row">
          <div class="col-md-4">
          <div class="form-group has-feedback">
            <label>Kota/Kabupaten</label>
            <select class="form-control" name="kota" id="kota">
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
            <select class="form-control" name="kecamatan" id="kecamatan">
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
            <select class="form-control" name="kelurahan" id="kelurahan">
              @foreach($kel as $key => $value)
              <option value="{{ $value->id_kelurahan }}" <?php if ($value->id_kelurahan == $edit->id_kelurahan) {
                echo "selected";
              } ?>>{{ $value->nama_kelurahan }}</option>
              @endforeach
            </select>
            <span class="form-control-feedback"></span>
          </div>
        </div>
        </div>
          <div class="form-row">
            <div class="col-md-12">
              <label>Masukan Lokasi Baru :</label>
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
              <label>ID LOGIN Customer :</label>
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
              <button type="submit" class="btn btn-primary btn-block btn-flat">Update</button>
            </div>
          </div>
        </form>
        </div>
        </div>
      </div>
    </div>
    </div>
  </section>
      <!-- /.content -->
 @endsection

@section('javascript')
<script src="http://maps.googleapis.com/maps/api/js"></script>
<script>
  
function initialize() {
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
    document.getElementById("latitude").value = posisiTitik.lat();
    document.getElementById("longitude").value = posisiTitik.lng();
    
}

  // even listner ketika peta diklik
  google.maps.event.addListener(map, 'click', function(event) {
    taruhMarker(this, event.latLng);
  });

}
  
// event jendela di-load  
google.maps.event.addDomListener(window, 'load', initialize);
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
@endsection
