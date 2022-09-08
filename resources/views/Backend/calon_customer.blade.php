@extends('layouts.admin')
@section('css')
  <link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    <section class="content-header">
      <ol class="breadcrumb">
        <li><a href="{{ route('home_admin') }}"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">Data Customer</li>
      </ol>
      <br/>
    </section>
    <section class="content">
            @if(\Session::has('msg_aktif_cus'))
           <h5> <div class="alert alert-info">
              {{ \Session::get('msg_aktif_cus')}}
            </div></h5>
            @endif
            @if(\Session::has('msg_hapus_cus'))
           <h5> <div class="alert alert-danger">
              {{ \Session::get('msg_hapus_cus')}}
            </div></h5>
            @endif
    <div class="row">
      <div class="col-xs-12">
          <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Data Calon Customer</h3>
                <div class="box-tools pull-right">
                  
                </div>
              </div>
              <div class="box-body">
                 <table class="table table-bordered table-striped" id="data-cus">
            <thead>
              <tr>
                <th width="25">ID</th>
                <th width="135">Nama Customer</th>
                <th width="75">No Telpon</th>
                <th width="70">ID Login</th>
                <th width="70">Username</th>
                <th width="80">Kota/Kab.</th>
                <th width="80">Kecamatan</th>
                <th width="80">Kelurahan</th>
                <th width="55">Status</th>
                <th width="180">Aksi</th>
              </tr>
            </thead>
              <tbody>
                 @foreach($customer as $key => $value)
                    <tr>
                      <td>{{ $value->id_customer }}</td>
                      <td>{{ $value->nama_customer }}</td>
                      <td>{{ $value->no_hp }}</td>
                      <td>{{ $value->id }}</td>
                      <td>{{ $value->username }}</td>
                      <td>{{ $value->nama_kota }}</td>
                      <td>{{ $value->nama_kecamatan }}</td>
                      <td>{{ $value->nama_kelurahan }}</td>
                      <td>{{ $value->status }}</td>
                      <td width="280">
                        <a href="{{ route('detail_calon',$value->id_customer) }}"><button class="btn btn-primary"
                        >&nbsp; <i class="fa fa-unlock"> &nbsp;</i></button></a> &nbsp;<a href="{{ route('hapus_calon',$value->id_customer) }}"><button class=" btn btn-danger" onclick="return confirm('apakah anda ingin menghapus data ini ?')">&nbsp; <i class="fa fa-trash"> &nbsp; </i></button></a>
                      </td>
                    </tr>
                    @endforeach
              </tbody>
          </table>
           </div>
       </div>          
      </div>
    </div>
  </section>
@endsection

@section('javascript')
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
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
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script type="text/javascript">
var table = $('#data-cus').DataTable();

  


  $('#modal-tambah-sub_agen').on('show.bs.modal',function(){
    $('input[name=id_sub]').val('');
    $('input[name=nama_sub]').val('');
    $('input[name=email]').val('');
    $('input[name=username]').val('');
    $('input[name=password]').val('');
    $('input[name=no_tlpn]').val('');
    $('textarea[name=alamat]').val('');
  });

  $('#c_sub_tipe').change(function(){
      $('#c_tipe').val($(this).find("option:selected").data('nama_tipe') );
    });
  $('#sub_tipe_c').change(function(){
      $('#tipe_c').val($(this).find("option:selected").data('nama_tipe') );
    });
</script>
@endsection