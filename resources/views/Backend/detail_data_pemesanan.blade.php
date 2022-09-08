@extends('layouts.admin')
@section('css')
<link rel="stylesheet" href="{{ asset('plugins/morris/morris.css') }}">
<link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
@endsection

@section('content')
  <section class="content-header">
    <ol class="breadcrumb">
      <li><a href="{{ route('home_admin') }}"><i class="fa fa-home"></i> Home</a></li>
      <li><a href="{{ route('data_pemesanan') }}"> Data Pemesanan</a></li>
      <li class="active">Detail Data Pemesanan</li>
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
              <a  class="btn btn-warning" href="{{ route('data_pemesanan') }}"> Kembali </a>
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
            <strong>Admin, PT.Gasindo Cirebon Prima.</strong><br/>
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
            <h4><span class="label label-warning">{{ $pesanan->bukti_bayar }}</span></h4>
          @elseif ($pesanan->metode_pembayaran == "Transfer")
          <h4><span class="label label-warning">{{ $pesanan->metode_pembayaran }}</span></h4>
          <br/>
            <img width="210px" src="{{ asset('uploads/'.$value->bukti_bayar) }}">
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
          @if ($value->status_pemesanan == "Konfirmasi Selesai")

          @else
        	<center>
        		<form action="{{ route('kirim_produk') }}" method="post">
        			{{ csrf_field() }}
        			<input type="hidden" name="id_pemesanan" value="{{ $pesanan->id_pemesanan }}" readonly>
        			
          		<button type="submit" class="btn btn-primary"><i class="fa fa-truck"></i> Kirim</button>
          	</center>
        		</form>
             <div class="pull-right">
              <form action="{{ route('tolak_pemesanan') }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="id_pemesanan" value="{{ $pesanan->id_pemesanan }}" readonly>
                 @foreach($detail as $key => $value)
                  <input type="hidden" name="id_detail[]" value="{{ $value->id_detail_pemesanan }}" class="form-control" readonly>
                  @endforeach
                <button type="submit" class="btn btn-danger" onclick="return confirm('apakah anda yakin ?')"><i class="fa fa-close"></i> Tolak</button>
              </form>

              </div>
              @endif
        </div>
      </div>
    </section>
    <br/>
@endsection

@section('javascript')
<script src="{{ asset('plugins/morris/morris.min.js') }}"></script>
<script src="{{ asset('plugins/raphael/raphael-min.js') }}"></script>
@endsection