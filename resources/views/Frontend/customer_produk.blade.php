@extends('layouts.customer')
@section('css')

@endsection

@section('content')
      <section class="content-header">
        
        <ol class="breadcrumb">
          <li><a href="{{ route('home_customer') }}"><i class="fa fa-dashboard"></i> Produk</a></li>
        </ol>
      </section>
      <br/>
      <br/>
      <!-- Main content -->
      <section class="content">
         @if(\Session::has('msg_stok_kurang'))
        <h5> <div class="alert alert-warning">
        {{ \Session::get('msg_stok_kurang')}}
        </div></h5>
      @endif
        <div class="row">

          @foreach($gas as $key => $value)
          <div class="col-md-4">
            <div class="box box-primary">
              <div class="box-body box-profile">
                <img class="profile-user-img img-responsive img-circle" src="{{ asset('uploads/'.$value->foto_gas) }}" style="width: 160px !important; height: 180px !important;" alt="picture of gas">

                <h3 class="profile-username text-center">{{ $value->nama_gas }}</h3>

                <p class="text-muted text-center">{{ $value->id_gas }}</p>

                <ul class="list-group list-group-unbordered">
                  <li class="list-group-item">
                    <b>Harga Isi Ulang</b> <a class="pull-right">Rp.{{ number_format($value->harga_refill,0,',','.') }}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Harga Isi + Tabung</b> <a class="pull-right">Rp.{{ number_format($value->harga,0,',','.') }}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Stok</b> <a class="pull-right">{{ $value->stok }}</a>
                  </li>
                </ul>

                <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal-pesan-{{ $key }}"><i class="fa fa-shopping-cart"></i> <b>Pesan</b></button>
              </div>
            </div>
            <div class="modal fade" id="modal-pesan-{{ $key }}" role="dialog">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Jumlah Produk</h4>
                </div>
                <div class="modal-body">
                 <form action="{{ route('pesan') }}" method="POST">
                  {{ csrf_field() }}
                  <div class="form-group has-feedback">
                    <label>Kode GAS :</label>
                    <input type="text" name="id_gas" value="{{ $value->id_gas }}" class="form-control" readonly>
                  </div>
                  <div class="form-group has-feedback">
                    <label>GAS :</label>
                    <input type="text" name="nama" class="form-control" value="{{ $value->nama_gas }}" readonly>
                  </div>
                  <div class="form-group has-feedback">
                    <label>Jenis Pembelian</label>
                    <select name="harga" id="harga" class="form-control" required>
                      <option>Pilih</option>
                      <option value="{{ $value->harga_refill }}" data-jenis_isi="{{ $value->harga_refill }}">Isi Ulang</option>
                      <option value="{{ $value->harga }}" data-jenis_isi="{{ $value->harga }}">Isi+Tabung</option>
                    </select>
                  </div>
                   <div class="form-group has-feedback">
                    <label>Jumlah :</label>
                    <input type="number" name="jmlh" class="form-control" placeholder="Masukan Jumlah" required>
                    <input type="hidden" name="stok" class="form-control" value="{{ $value->stok }}">
                  </div>
                  <div class="row">
                    <div class="col-xs-4 col-xs-offset-8">
                      <button type="submit" class="btn btn-primary btn-block btn-flat"><i class="fa fa-plus-circle"> Lanjutkan </i></button>
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
        </div>
        @endforeach
        </div>
        <!-- /.box -->
  </section>
      <!-- /.content -->
 @endsection

@section('javascript')
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script type="text/javascript">
</script>
@endsection
