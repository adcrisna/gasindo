@extends('layouts.gudang')
@section('css')
  <link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
@endsection

@section('content')
    <section class="content-header">
      <ol class="breadcrumb">
        <li><a href="{{ route('home_gudang') }}"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">Histori Produk</li>
      </ol>
      <br/>
    </section>
    <section class="content">
    <div class="row">
      <div class="col-xs-12">
          <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Histori Produk</h3>
                <div class="pull-right">
                	<button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#modal-print"><i class="fa fa-print"></i> Laporan</button>
	            </div>
              </div>
              <div class="box-body">
                <table class="table table-bordered table-striped" id="data-gas">
                <thead>
                  <tr>
                    <th width="40">Kode Produk</th>
                    <th width="100">Jumlah</th>
                    <th width="100">Status</th>
                    <th width="65">Keterangan</th>
                    <th width="40">Tanggal</th>
                    <th width="150">Bukti Pembelian</th>
                  </tr>
                </thead>
                  <tbody>
                     @foreach($histori as $key => $value)
                        <tr>
                          <td>{{ $value->id_gas }}</td>
                          <td>{{ $value->jumlah_gas }}</td>
                          <td>{{ $value->status_gas }}</td>
                          <td>{{ $value->keterangan_gas }}</td>
                          <td>{{ $value->tgl_gas }}</td>
                          <td>
                            @if ($value->keterangan_gas == "Penambahan Stok Produk")
                            <img width="150px" src="{{ asset('uploads/'.$value->bukti_pembelian) }}">
                            @elseif ($value->keterangan_gas == "Pengurangan Stok Produk")
                            <img width="150px" src="{{ asset('uploads/'.$value->bukti_pembelian) }}">
                            @elseif ($value->keterangan_gas == "Penambahan Produk Baru")
                            <img width="150px" src="{{ asset('uploads/'.$value->bukti_pembelian) }}">
                            @else
                            {{ $value->bukti_pembelian }}
                            @endif
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
    <div class="modal fade" id="modal-print" role="dialog">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Pilih Periode Laporan</h4>
                </div>
                <div class="modal-body">
                 <form action="{{ route('laporan_produk') }}" method="POST">
                  {{ csrf_field() }}
                  <div class="form-group has-feedback">
                    <label>Dari Tanggal :</label>
                    <input type="date" name="tgl_dari" class="form-control" required>
                  </div>
                  <div class="form-group has-feedback">
                    <label>Sampai Tanggal :</label>
                    <input type="date" name="tgl_sampai" class="form-control" required>
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