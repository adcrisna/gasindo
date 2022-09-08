@extends('layouts.admin')
@section('css')
<link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
@endsection

@section('content')
  <section class="content-header">
    <ol class="breadcrumb">
      <li><a href="{{ route('home_admin') }}"><i class="fa fa-home"></i> Home</a></li>
      <li class="active">Data Penjualan</li>
    </ol>
  </section>
  <br/>
      @if(\Session::has('msg_kirim_gas'))
        <h5> <div class="alert alert-info">
        {{ \Session::get('msg_kirim_gas')}}
        </div></h5>
      @endif
  <br/>
  <br/>
  <section class="content">
   <div class="row">
      <div class="col-xs-12">
          <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Laporan Penjualan</h3>
                <div class="pull-right">
                  <button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#modal-print"><i class="fa fa-print"></i> Laporan</button>
              </div>
              </div>
              <div class="box-body">
                <table class="table table-bordered table-striped" id="data-gas">
                <thead>
                  <tr>
                      <th>ID Pemesanan</th>
                      <th>No Invoice</th>
                      <th>Tanggal Pemesanan</th>
                      <th>Total Pembayaran</th>
                      <th>Metode Pembayaran</th>
                      <th>Status</th>
                      <th>Detail</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($pesanan as $key => $value)
                    <tr>
                      <td>{{ $value->id_pemesanan }}</td>
                      <td>{{ $value->no_invoice }}</td>
                      <td>{{ $value->tgl_pemesanan }}</td>
                      <td>Rp.{{ number_format($value->total_bayar,0,',','.') }}</td>
                      <td>{{ $value->metode_pembayaran }}</td>
                      <td>@if ($value->status_pemesanan == "Diproses")
                        <span class="label label-warning">{{ $value->status_pemesanan }}</span>
                      @elseif ($value->status_pemesanan == "Dikirim")
                         <span class="label label-primary">{{ $value->status_pemesanan }}</span>
                      @elseif ($value->status_pemesanan == "Selesai")
                           <span class="label label-success">{{ $value->status_pemesanan }}</span>
                      @endif
                     </td>
                     <td><a href="{{ route('detail_penjualan',$value->id_pemesanan) }}" class="button btn btn-default"><i class="fa fa-eye"></i> </a></td>
                    </tr>
                    @endforeach
                  </tbody>
              </table>
           </div>
       </div>          
      </div>
    </div>
    <br/>
  </section>
  <div class="modal fade" id="modal-print" role="dialog">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Pilih Periode Laporan</h4>
                </div>
                <div class="modal-body">
                 <form action="{{ route('laporan_penjualan') }}" method="POST">
                  {{ csrf_field() }}
                  <div class="form-group has-feedback">
                    <label>Dari Tanggal :</label>
                    <input type="date" name="tgl_dari" class="form-control" required="">
                  </div>
                  <div class="form-group has-feedback">
                    <label>Sampai Tanggal :</label>
                    <input type="date" name="tgl_sampai" class="form-control" required="">
                  </div>
                  <div class="row">
                    <div class="col-xs-4 col-xs-offset-8">
                      <button type="submit" class="btn btn-primary btn-block btn-flat"><i class="fa fa-print"> </i></button>
                    </div>
                  </div>
                 </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
              </div>
            </div>
          </div>
@endsection
@section('javascript')
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>

<script type="text/javascript">
  var table = $('#data-gas').DataTable();
</script>
@endsection