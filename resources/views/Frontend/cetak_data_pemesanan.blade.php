<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ $title }}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css') }}">
  <style media="print">
 @page {
  size: auto;
  margin: 0;
       }
</style>

</head>
<div class="content-wrapper">
    <div class="container">
      <section class="content-header">
          <br/>
          <br/>
      </section>

      <!-- Main content -->
      <section class="invoice">
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> PT. GASINDO CIREBON PRIMA
            
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

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 table-responsive">
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
                <th>Pajak</th>
                <td>Sudah Termasuk Pajak</td>
              </tr>
              <tr>
                <th>Pengiriman:</th>
                <td>Rp.{{ number_format($informasi->ongkir,0,',','.') }}</td>
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
    </section>
      <!-- /.content -->
    </div>
  </div>

<script>
    window.print();
  </script>
<script src="{{ asset('plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ asset('plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('plugins/fastclick/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/app.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
@yield('javascript')
</body>
</html>