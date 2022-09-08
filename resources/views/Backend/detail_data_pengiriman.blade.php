@extends('layouts.pengiriman')
@section('css')
<link rel="stylesheet" href="{{ asset('plugins/morris/morris.css') }}">
<link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
@endsection

@section('content')
  <section class="content-header">
    <ol class="breadcrumb">
      <li><a href="{{ route('home_admin') }}"><i class="fa fa-home"></i> Home</a></li>
      <li><a href="{{ route('data_pengiriman') }}"> Data Pengiriman</a></li>
      <li class="active"> Detail Data Pengiriman</li>
    </ol>
  </section>
  <br/>
  <br/>
   <section class="invoice">
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> PT. GASINDO CIREBON PRIMA
            <div class="pull-right">
              <a  class="btn btn-warning" href="{{ route('data_pengiriman') }}"> Kembali </a>
            </div>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          From
          <address>
            <strong>Admin, PT.Gasindo Cirebon Prima.</strong><br>
            Jalan Tuperev No.40/54<br>
            Kedawung, Cirebon, Jawa Barat 45153<br>
            Phone: (231) 123-5432<br>
            Email: gasindocirebonprima@gmail.com
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          To
          <address>
            <strong>{{ $pesanan->nama_customer }}</strong><br>
            {{ $pesanan->alamat }}<br>
            {{ $pesanan->nama_kelurahan }}, {{ $pesanan->nama_kecamatan }}, {{ $pesanan->nama_kota }}<br>
            Phone: {{ $pesanan->no_hp }}<br>
            Email: {{ $pesanan->email_customer }}
          </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
          <b>Invoice :</b> {{ $pesanan->no_invoice }}<br>
          <br>
          <b>Order ID:</b> {{ $pesanan->id_pemesanan }}<br>
          <b>Tanggal Pemesanan :</b> {{ $pesanan->tgl_pemesanan }}<br>
           <b>Status :</b> {{ $pesanan->status_pemesanan }}<br>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="form-row">
          <div class="col-md-12">
            <div id="gMap" style="width:100%;height:400px;"></div>
            <br/>
            <br/>
          </div>
        </div>
      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
          <div class="pull-left">
            <p class="lead">Detail Pemesanan :</p>
          </div>
          <table class="table table-striped">
            <thead>
            <tr>
              <th>Qty</th>
              <th>Produk</th>
              <th>No Invoice</th>
              <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
              @foreach($detail as $key => $value)
            <tr>
              <td>{{ $value->jumlah_beli }}</td>
              <td>{{ $value->nama_gas }}</td>
              <td>{{ $value->no_invoice }}</td>
              <td>Rp.{{ number_format($value->sub_total,0,',','.') }}</td>
            </tr>
            @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
          <p class="lead">Metode Pembayaran :</p>

          @if ($pesanan->metode_pembayaran == "Bayar Ditempat")
            <h4><span class="label label-warning">{{ $value->bukti_bayar }}</span></h4>
          @elseif ($pesanan->metode_pembayaran == "Transfer")
          <h4><span class="label label-warning">{{ $value->metode_pembayaran }}</span></h4>
          <br/>
            <img width="100px" src="{{ asset('uploads/'.$value->bukti_bayar) }}">
          @endif
        </div>
        <!-- /.col -->
        <div class="col-xs-6">
          <p class="lead">Total Pembayaran</p>

          <div class="table-responsive">
            <table class="table">
              <tr>
                <th style="width:50%">Subtotal:</th>
                <th style="display: none;">{{ $total = 0 }}</th>
                 @foreach($detail as $key => $value)
                 <th style="display: none;">{{ $total += $value->sub_total }}</th>
                 @endforeach
                <td>Rp.{{ number_format($total,0,',','.') }}</td>
              </tr>
              <tr>
                 <th>Pajak 10%</th>
                <td>Rp.{{ number_format($total*0.1,0,',','.') }}</td>
              </tr>
              <tr>
               <th>Pengiriman:</th>
                <td>Rp.{{ number_format($pesanan->biaya_pengiriman,0,',','.') }}</td>
              </tr>
              <tr>
                <th>Total:</th>
                <td>Rp.{{ number_format($pesanan->total_bayar,0,',','.') }}</td>
              </tr>
            </table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <br/>
      <br/>
      <!-- this row will not appear when printing -->
      <div class="row">
        <div class="col-xs-12">
        	<center>
        		<form action="{{ route('selesai') }}" method="post">
        			{{ csrf_field() }}
        			<input type="hidden" name="id_pemesanan" value="{{ $pesanan->id_pemesanan }}" readonly>
              <input type="hidden"  name="latitude" id="latitude" class="form-control" value="{{ $pesanan->latitude }}" readonly>
              <input type="hidden"  name="longitude" id="longitude" class="form-control" value="{{ $pesanan->longitude }}" readonly>
          		<button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Selesai</button>
        		</form>
          	</center>
            <div class="pull-right">
              <a href="{{ route('batalkan',$pesanan->id_pemesanan) }}" class="btn btn-danger"><i class="fa fa-close"></i> Batalkan</a>
            </div>
        </div>
      </div>
    </section>
    <br/>
@endsection

@section('javascript')
<script src="{{ asset('plugins/morris/morris.min.js') }}"></script>
<script src="{{ asset('plugins/raphael/raphael-min.js') }}"></script>
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
@endsection