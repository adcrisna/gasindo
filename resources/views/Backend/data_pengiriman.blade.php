@extends('layouts.pengiriman')
@section('css')
<link rel="stylesheet" href="{{ asset('plugins/morris/morris.css') }}">
<link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
@endsection

@section('content')
  <section class="content-header">
    <ol class="breadcrumb">
      <li><a href="{{ route('home_penjualan') }}"><i class="fa fa-home"></i> Home</a></li>
      <li class="active">Data Pengiriman</li>
    </ol>
  </section>
  <br/>
  <br/>
  <section class="content">
      @if(\Session::has('msg_selesai_kirim'))
        <h5> <div class="alert alert-info">
        {{ \Session::get('msg_selesai_kirim')}}
        </div></h5>
      @endif
      @if(\Session::has('msg_batal_kirim'))
        <h5> <div class="alert alert-warning">
        {{ \Session::get('msg_batal_kirim')}}
        </div></h5>
      @endif
    <div class="row">
        <div class="col-xs-12">
          <div class="box box-danger">
            <div class="box-header">
              <h3 class="box-title">Data Pengiriman</h3>

              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>ID Pemesanan</th>
                  <th>No Invoice</th>
                  <th>Tanggal Pemesanan</th>
                  <th>Total Pembayaran</th>
                  <th>Metode Pembayaran</th>
                  <th>Status</th>
                  <th>Detail</th>
                </tr>
                @foreach($pesanan as $key => $value)
                <tr>
                  <td>{{ $value->id_pemesanan }}</td>
                  <td>{{ $value->no_invoice }}</td>
                  <td>{{ $value->tgl_pemesanan }}</td>
                  <td>Rp.{{ number_format($value->total_bayar,0,',','.') }}</td>
                  <td>{{ $value->metode_pembayaran }}</td>
                  <td>@if ($value->status_pemesanan == "Diproses")
                    <span class="label label-warning">{{ $value->status_pemesanan }}</span>
                  @elseif ($value->status_pemesanan == "Pengiriman")
                     <span class="label label-primary">{{ $value->status_pemesanan }}</span>
                  @elseif ($value->status_pemesanan == "Selesai")
                       <span class="label label-success">{{ $value->status_pemesanan }}</span>
                  @endif
                 </td>
                 <td><a href="{{ route('detail_data_pengiriman',$value->id_pemesanan) }}" class="button btn btn-default"><i class="fa fa-eye"></i> </a></td>
                </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
    <br/>
  </section>
@endsection

@section('javascript')
<script src="{{ asset('plugins/morris/morris.min.js') }}"></script>
<script src="{{ asset('plugins/raphael/raphael-min.js') }}"></script>
@endsection