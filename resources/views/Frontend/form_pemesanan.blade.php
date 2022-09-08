@extends('layouts.customer')
@section('css')

@endsection

@section('content')
      <section class="content-header">
        <br/>
        <br/>
        <ol class="breadcrumb">
          <li><a href="{{ route('home_customer') }}"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Form Pemesanan</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        @if(\Session::has('msg_tambah_pesanan'))
           <h5> <div class="alert alert-success">
              {{ \Session::get('msg_tambah_pesanan')}}
            </div></h5>
            @endif
            @if(\Session::has('msg_edit_detail'))
           <h5> <div class="alert alert-warning">
              {{ \Session::get('msg_edit_detail')}}
            </div></h5>
            @endif
            @if(\Session::has('msg_tambah_gagal'))
           <h5> <div class="alert alert-danger">
              {{ \Session::get('msg_tambah_gagal')}}
            </div></h5>
            @endif
             @if(\Session::has('msg_hapus_pemesanan'))
           <h5> <div class="alert alert-danger">
              {{ \Session::get('msg_hapus_pemesanan')}}
            </div></h5>
            @endif
             @if(\Session::has('msg_gagal_pesan'))
           <h5> <div class="alert alert-danger">
              {{ \Session::get('msg_gagal_pesan')}}
            </div></h5>
            @endif
             @if(\Session::has('msg_stok_kurang'))
              <h5> <div class="alert alert-warning">
              {{ \Session::get('msg_stok_kurang')}}
              </div></h5>
            @endif
      <div class="row">
          <div class="col-xs-5">
              <div class="box box-danger">
                  <div class="box-header">
                    <h3 class="box-title">Pemesanan</h3>
                    <div class="box-tools pull-right">
                    <form action="{{ route('cancel_pemesanan') }}" method="POST" enctype="multipart/form-data">
                  {{ csrf_field() }}
                  <div class="form-group has-feedback">
                      
                      <input type="hidden" name="no_invoice" value="{{ $inv->no_invoice }}" class="form-control" readonly>
                    </div>
                        <button type="submit" class="btn btn-warning btn-block btn-flat" onclick="return confirm('Apakah anda yakin ingin membatalkan Pemesanan ?')"><i class="fa fa-sign-out"></i> Cancel</button>
                </form>
                  </div>
              <div class="box-body">
                <p>No Invoice :  {{ $inv->no_invoice }} </p>
                <p>Nama Customer : {{ $nama }}</p>
                <p>Tanggal Pemesanan : {{ $tgl }}</p>
              </div>
            </div>
          </div>
        </div>
         <div class="col-xs-7">
              <div class="box box-danger">
                  <div class="box-header">
                    <h3 class="box-title">Detail Pemesanan</h3>
                    </div>
              <div class="box-body">
                <table class="table table-striped" id="data-detail">
                  <thead>
                    <tr>
                      <th style="display: none;">ID Detail</th>
                      <th width="220">No Invoice</th>
                      <th style="display: none;" width="150">ID Produk</th>
                      <th width="170">Nama Produk</th>
                      <th width="80">Jumlah</th>
                      <th style="display: none;" width="110">Sub Total</th>
                      <th width="160">Sub Total</th>
                      <th width="150">Aksi</th>
                    </tr>
                  </thead>
                    <tbody>
                       @foreach($detail as $key => $value)
                          <tr>
                            <td style="display: none;">{{ $value->id_detail_pemesanan }}</td>
                            <td>{{ $value->no_invoice }}</td>
                            <td style="display: none;">{{ $value->id_gas }}</td>
                            <td>{{ $value->nama_gas }}</td>
                            <td>{{ $value->jumlah_beli }}</td>
                            <td style="display: none;">{{$value->sub_total }}</td>
                            <td>Rp.{{ number_format($value->sub_total,0,',','.') }}</td>
                            <td width="150">
                              <button class="btn btn-primary btn-ubah-detail"
                              > &nbsp; &nbsp;<i class="fa fa-edit"> &nbsp; &nbsp; </i></button> &nbsp; <a href="{{ route('hapus_pemesanan',$value->id_detail_pemesanan) }}"><button class=" btn btn-danger" onclick="return confirm('apakah anda ingin menghapus data ini ?')"> &nbsp; &nbsp;<i class="fa fa-trash"> &nbsp; &nbsp; </i></button></a>
                            </td>
                          </tr>
                          @endforeach
                    </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-7">
              <div class="box box-danger">
                  <div class="box-header">
                    <h3 class="box-title">Tambah Produk</h3>
                  
                  </div>
              <div class="box-body">
                <table class="table table-bordered table-striped" id="data-produk">
                <thead>
                  <tr>
                    <th style="display: none;" width="40">Kode</th>
                    <th width="100">Foto</th>
                    <th width="100">Produk</th>
                    <th width="65">Harga Isi Ulang</th>
                    <th width="65">Harga Isi + Tabung</th>
                    <th style="display: none;" width="35">Stok</th>
                    <th width="65">Aksi</th>
                  </tr>
                </thead>
                  <tbody>
                     @foreach($gas as $key => $value)
                        <tr>
                          <td style="display: none;">{{ $value->id_gas }}</td>
                          <td><img width="100px" src="{{ asset('uploads/'.$value->foto_gas) }}"></td>
                          <td>{{ $value->nama_gas }}</td>
                          <td>Rp.{{ number_format($value->harga_refill,0,',','.') }}</td>
                          <td>Rp.{{ number_format($value->harga,0,',','.') }}</td>
                          <td style="display: none;">{{ $value->stok }}</td>
                          <td>
                            <button class="btn btn-success btn-tambah-produk"> &nbsp; <i class="fa fa-plus"> &nbsp;</i></button>
                          </td>
                        </tr>
                        @endforeach
                  </tbody>
              </table>
              </div>
            </div>
          </div>
         <div class="col-xs-5">
              <div class="box box-danger">
                  <div class="box-header">
                    <h3 class="box-title">Total Belanja</h3>
                  </div>
              <div class="box-body">
                
                    <div style="display: none">{{ $sub_ttl = 0 }}</div>
                    @foreach($detail as $key => $value)
                   <div style="display: none">{{ $sub_ttl += $value->sub_total }}</div>
                   @endforeach
                   <h4>Total Pembelian : <div class="pull-right">
                   <b>Rp.{{ number_format($sub_ttl,0,',','.') }}</b>
                  </div></h4>
                  <h4>Pajak 10% : <div class="pull-right">
                   <b>Rp.{{ number_format($sub_ttl*0.1,0,',','.') }}</b>
                  </div></h4> 
                <h4>Pengiriman : <div class="pull-right">
                 <p>Rp.{{ number_format($biaya_ongkir,0,',','.') }}</p></div></h4>
                 <div style="display: none">
                  {{ $total = $sub_ttl + $biaya_ongkir}}
                </div>
                 <h4>Total Pembayaran : 
                  <div class="pull-right">
                 <b>Rp.{{ number_format($total,0,',','.') }}</b>
               </div></h4>
                  <h4>Transfer : 
                  <div class="pull-right">
                 <b>{{ $informasi->no_rekening }}</b>
               </div></h4><br/>
                <form action="{{ route('buat_pemesanan') }}" method="POST" enctype="multipart/form-data">
                  {{ csrf_field() }}
                  <div class="form-group has-feedback">
                      <input type="hidden" name="no_invoice" value="{{ $inv->no_invoice }}" class="form-control" readonly>
                      <input type="hidden" name="tgl_pemesanan" value="{{ $tgl }}" class="form-control" readonly>
                      <input type="hidden" name="total_bayar" value="{{ $total }}" class="form-control" readonly>
                      <input type="hidden" name="id" value="{{ $id }}" class="form-control" readonly>
                      <input type="hidden" name="ongkir" value="{{ $biaya_ongkir }}" class="form-control" readonly>
                      @foreach($detail as $key => $value)
                      <input type="hidden" name="id_detail[]" value="{{ $value->id_detail_pemesanan }}" class="form-control" readonly>
                      @endforeach
                    </div>
                    <div class="form-group has-feedback">
                      <label>Metode Pembayaran</label>
                      <select class="form-control" id="metode" name="metode" required>
                        <option>Pilih</option>
                        <option value="Cod">Bayar Ditempat</option>
                        <option value="Transfer">Transfer</option>
                      </select>
                    </div>
                    <div class="form-group has-feedback">
                      <input type="file" name="bukti_bayar" id="bukti" class="form-control" value="">
                    </div>
                     <div class="row">
                      <div class="col-xs-4 col-xs-offset-8">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Pesan</button>
                      </div>
                      </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </section>
      <div class="modal fade" id="modal-ubah-detail" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Ubah Pemesanan</h4>
          </div>
          <div class="modal-body">
            <form action="{{ route('update_pemesanan') }}" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}
            <div class="form-group has-feedback">
              <input type="hidden" name="id_detail" readonly class="form-control">
              <input type="hidden" name="no_invoice" readonly class="form-control">
            </div>
            <div class="form-group has-feedback">
              <input type="hidden" name="nama_gas" class="form-control" readonly>
              <input type="hidden" name="id_gas" class="form-control" readonly>
            </div>
             <div class="form-group has-feedback">
              <label>Jumlah</label>
              <input type="number" name="jumlah" class="form-control" >
              <input type="hidden" name="old_jumlah" class="form-control" >
              <input type="hidden" name="sub_total" class="form-control" >
            </div>
            <div class="row">
              <div class="col-xs-4 col-xs-offset-8">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Update</button>
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
    <div class="modal fade" id="modal-tambah-detail" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Tambah Pemesanan</h4>
          </div>
          <div class="modal-body">
            <form action="{{ route('tambah_pemesanan') }}" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}
            <div class="form-group has-feedback">
              <input type="hidden" name="id_produk" class="form-control" readonly>
              <input type="text" name="nama_produk" class="form-control" readonly>
              <input type="hidden" name="stok" class="form-control" readonly>
               @foreach($detail as $key => $value)
                <input type="hidden" name="no_invoice" value="{{ $value->no_invoice }}" class="form-control" readonly> 
                @endforeach
            </div>
             <div class="form-group has-feedback">
                <label>Jenis Pembelian</label>
                <select name="jenis" id="harga" class="form-control" required>
                  <option>Pilih</option>
                  <option value="1" >Isi Ulang</option>
                  <option value="2" >Isi+Tabung</option>
                </select>
                  </div>
             <div class="form-group has-feedback">
              <label>Jumlah</label>
              <input type="number" name="jumlah" class="form-control" required>
            </div>
            <div class="row">
              <div class="col-xs-4 col-xs-offset-8">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Tambah</button>
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
      <!-- /.content -->
 @endsection

@section('javascript')
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>

<script type="text/javascript">
  var detail = $('#data-detail').DataTable();

  $('#data-detail').on('click','.btn-ubah-detail',function(){
    row = detail.row( $(this).closest('tr') ).data();
    console.log(row);
    $('input[name=id_detail]').val(row[0]);
    $('input[name=no_invoice]').val(row[1]);
    $('input[name=id_gas]').val(row[2]);
    $('input[name=nama_gas]').val(row[3]);
    $('input[name=jumlah]').val(row[4]);
    $('input[name=old_jumlah]').val(row[4]);
    $('input[name=sub_total]').val(row[5]);
    $('#modal-ubah-detail').modal('show');
  });

  var produk = $('#data-produk').DataTable();

  $('#data-produk').on('click','.btn-tambah-produk',function(){
    row = produk.row( $(this).closest('tr') ).data();
    console.log(row);
    $('input[name=id_produk]').val(row[0]);
    $('input[name=nama_produk]').val(row[2]);
    $('input[name=jumlah]').val('');
    $('input[name=stok]').val(row[5]);
    $('#modal-tambah-detail').modal('show');
  });

$("#metode").change(function() {
      console.log($("#metode option:selected").val());
      if ($("#metode option:selected").val() == 'Cod') {
        $('#bukti').hide();
        $('informasi').hide();
      } else {
        $('#bukti').show();
      }
    });
</script>
@endsection
