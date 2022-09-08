@extends('layouts.gudang')
@section('css')
  <link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
@endsection

@section('content')
    <section class="content-header">
      <ol class="breadcrumb">
        <li><a href="{{ route('home_gudang') }}"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">Data Produk</li>
      </ol>
      <br/>
    </section>
  <section class="content">
            @if(\Session::has('msg_simpan_gas'))
           <h5> <div class="alert alert-info">
              {{ \Session::get('msg_simpan_gas')}}
            </div></h5>
            @endif
            @if(\Session::has('msg_tambah_stok'))
           <h5> <div class="alert alert-info">
              {{ \Session::get('msg_tambah_stok')}}
            </div></h5>
            @endif
            @if(\Session::has('msg_kurang_stok'))
           <h5> <div class="alert alert-info">
              {{ \Session::get('msg_kurang_stok')}}
            </div></h5>
            @endif
            @if(\Session::has('msg_hapus_gas'))
           <h5> <div class="alert alert-danger">
              {{ \Session::get('msg_hapus_gas')}}
            </div></h5>
            @endif
            @if(\Session::has('msg_edit_gas'))
           <h5> <div class="alert alert-warning">
              {{ \Session::get('msg_edit_gas')}}
            </div></h5>
            @endif
             @if(\Session::has('msg_gagal'))
           <h5> <div class="alert alert-danger">
              {{ \Session::get('msg_gagal')}}
            </div></h5>
            @endif
    <div class="row">
      <div class="col-xs-12">
          <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Data Produk</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#modal-tambah-gas"><i class="fa fa-plus"> Tambah Produk</i></button>
                </div>
              </div>
              <div class="box-body">
                <table class="table table-bordered table-striped" id="data-gas">
                <thead>
                  <tr>
                    <th width="40">Kode</th>
                    <th width="100">Foto</th>
                    <th width="100">GAS</th>
                    <th width="65">Harga Isi Ulang</th>
                    <th width="65">Harga Isi + Tabung</th>
                    <th width="40">Stok</th>
                    <th width="285">Aksi</th>
                  </tr>
                </thead>
                  <tbody>
                     @foreach($gas as $key => $value)
                        <tr>
                          <td>{{ $value->id_gas }}</td>
                          <td><img width="100px" src="{{ asset('uploads/'.$value->foto_gas) }}"></td>
                          <td>{{ $value->nama_gas }}</td>
                          <td>{{ $value->harga_refill }}</td>
                          <td>{{ $value->harga }}</td>
                          <td>{{ $value->stok }}</td>
                          <td>
                            <button class="btn btn-primary btn-stok-tambah">&nbsp; <i class="fa fa-plus-circle"> &nbsp; </i></button> &nbsp; <button class="btn btn-warning btn-stok-kurang">&nbsp; <i class="fa fa-minus-circle"> &nbsp; </i></button> &nbsp; 
                            <button class="btn btn-default btn-detail-gas"
                            data-d_id_g="{{ $value->id_gas }}"
                            data-d_nama_g="{{ $value->nama_gas }}"
                            data-d_foto="{{ asset('uploads/'.$value->foto_gas) }}"
                            data-d_harga_r="{{ $value->harga_refill }}"
                            data-d_harga="{{ $value->harga }}"
                            data-d_stok="{{ $value->stok }}"
                            data-d_id="{{ $value->id }}"
                            data-d_created_at="{{ $value->created_at }}"
                            data-d_updated_at="{{ $value->updated_at }}"
                            data-d_nama="{{ $value->nama }}"
                            > &nbsp; <i class="fa fa-eye"> &nbsp; </i></button> &nbsp;
                            <a href="{{ route('tampil_edit',$value->id_gas) }}"><button class="btn btn-success btn-edit-gas"> &nbsp; <i class="fa fa-edit"> &nbsp;</i></button></a> &nbsp;<a href="{{ route('hapus_gas',$value->id_gas) }}"><button class=" btn btn-danger" onclick="return confirm('apakah anda ingin menghapus data ini ?')"> &nbsp; <i class="fa fa-trash"> &nbsp; </i></button></a>
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
   <div class="modal fade" id="modal-tambah-gas" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Form Tambah Data Produk</h4>
        </div>
        <div class="modal-body">
          <form action="{{ route('simpan_gas') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group has-feedback">
            <label>Kode Gas :</label>
            <input type="text" name="id_gas" class="form-control" placeholder="Masukan Kode Gas" required>
          </div>
          <div class="form-group has-feedback">
            <label>Gas :</label>
            <input type="text" name="nama" class="form-control" placeholder="Nama Gas" required>
          </div>
          <div class="form-group has-feedback">
            <label>Berat:</label>
            <input type="number" name="berat" class="form-control" placeholder="Berat Gas" required>
          </div>
           <div class="form-group has-feedback">
            <label>Foto Gas :</label>
            <input type="file" name="foto_gas" class="form-control" required>
          </div>
          <div class="form-group has-feedback">
            <label>Harga Isi Ulang :</label>
            <input type="number" name="harga_refill" class="form-control" placeholder="Masukan Harga Isi Ulang" required>
          </div>
          <div class="form-group has-feedback">
            <label>Harga Isi Dengan Tabung :</label>
            <input type="number" name="harga" class="form-control" placeholder=" Masukan Harga" required>
          </div>
          <label>Stok :</label>
          <div class="form-group has-feedback">
            <input type="text" name="stok" class="form-control" placeholder="Stok" required>
         </div>
         <div class="form-group has-feedback">
            <label>Bukti Pembelian :</label>
            <input type="file" name="bukti_p" class="form-control" required>
          </div>
         <div class="form-group has-feedback">
            <input type="hidden" name="id" class="form-control" value="{{ $id }}" required>
         </div>
          <div class="row">
            <div class="col-xs-4 col-xs-offset-8">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Simpan</button>
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
  <div class="modal fade" id="modal-detail-gas" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Detail Data Produk</h4>
        </div>
        <div class="modal-body">
        <form>
          <table class="table table-striped" id="data-table-gas">
            <tbody>
              <tr>  
                <th width="150">ID GAS :</th>
                <td><span id="n_id_g"></span></td>
              </tr>
              <tr>  
                <th width="150">GAS :</th>
                <td><span id="n_nama_g"></span></td>
              </tr>
              <tr>  
                <th width="150">FOTO :</th>
                <td><div id="a_foto"></div></td>
              </tr>
               <tr>  
                <th width="150">ISI GAS :</th>
                <td><span id="n_isi"></span></td>
              </tr>
              <tr>  
                <th width="150">HARGA ISI ULANG</th>
                <td><span id="n_harga_r"></span></td>
              </tr>
              <tr>  
                <th width="150">HARGA ISI + TABUNG</th>
                <td><span id="n_harga"></span></td>
              </tr>
              <tr>  
                <th width="150">STOK</th>
                <td><span id="n_stok"></span></td>
              </tr>
              <!-- <tr>  
                <th width="150">Created :</th>
                <td><span id="n_created"></span></td>
              </tr>
              <tr>  
                <th width="150">Created :</th>
                <td><span id="n_updated"></span></td>
              </tr>
              <tr>  
                <th width="150">Last Updated By :</th>
                <td><span id="n_nama"></span></td>
              </tr> -->
            </tbody>
          </table>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modal-tambah-stok" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Form Tambah Stok Produk</h4>
        </div>
        <div class="modal-body">
         <form action="{{ route('tambah_gas') }}" method="POST" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="form-group has-feedback">
            <label>Kode GAS :</label>
            <input type="text" name="t_id_g" class="form-control" readonly>
          </div>
          <div class="form-group has-feedback">
            <label>GAS :</label>
            <input type="text" name="t_nama" class="form-control" readonly>
          </div>

           <div class="form-group has-feedback">
            <label>Jumlah :</label>
            <input type="number" name="t_stok" class="form-control" placeholder=" Masukan Jumlah Gas yang Ditambah" required>
          </div>
          <!-- <div class="form-group has-feedback">
            <label>Keterangan :</label>
            <textarea name="t_keterangan" class="form-control" placeholder="Masukan Keterangan" required></textarea>
          </div> -->
          <div class="form-group has-feedback">
            <label>Bukti Pembelian :</label>
            <input type="file" name="bukti_p" class="form-control" required>
          </div>
          <div class="row">
            <div class="col-xs-4 col-xs-offset-8">
              <button type="submit" class="btn btn-primary btn-block btn-flat"><i class="fa fa-plus-circle"> Tambahkan </i></button>
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
  <div class="modal fade" id="modal-kurang-stok" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Form Kurangi Stok Produk</h4>
        </div>
        <div class="modal-body">
         <form action="{{ route('kurang_gas') }}" method="POST" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="form-group has-feedback">
            <label>ID GAS :</label>
            <input type="text" name="k_id_g" class="form-control" readonly>
          </div>
          <div class="form-group has-feedback">
            <label>GAS :</label>
            <input type="text" name="k_nama" class="form-control" readonly>
          </div>
           <div class="form-group has-feedback">
            <label>Jumlah :</label>
            <input type="number" name="k_stok" class="form-control" placeholder=" Masukan Jumlah Gas Yang Dikurangi" required>
          </div>
          <!-- <div class="form-group has-feedback">
            <label>Keterangan :</label>
            <textarea name="k_keterangan" class="form-control" placeholder="Masukan Keterangan" required></textarea>
          </div> -->
          <div class="form-group has-feedback">
            <label>Bukti Pembelian :</label>
            <input type="file" name="bukti_p" class="form-control" required>
          </div>
          <div class="row">
            <div class="col-xs-4 col-xs-offset-8">
              <button type="submit" class="btn btn-primary btn-block btn-flat"><i class="fa fa-minus-circle"> Kurangin </i></button>
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

  $('#data-gas').on('click','.btn-detail-gas',function(){
    var i_id_g = $(this).data('d_id_g');
    var i_nama_g = $(this).data('d_nama_g');
    var i_foto = $(this).data('d_foto');
    var i_isi = $(this).data('d_isi');
    var i_harga_r = $(this).data('d_harga_r');
    var i_harga = $(this).data('d_harga');
    var i_stok = $(this).data('d_stok');
    var i_id = $(this).data('d_id');
    var i_created = $(this).data('d_created_at');
    var i_updated = $(this).data('d_updated_at');
    var i_nama = $(this).data('d_nama');
    
    $('#n_id_g').text(i_id_g);
    $('#n_nama_g').text(i_nama_g);
    $('#n_isi').text(i_isi);
    $('#n_harga_r').text(i_harga_r);
    $('#n_harga').text(i_harga);
    $('#n_stok').text(i_stok);
    $('#n_id').text(i_id);
    $('#n_created').text(i_created);
    $('#n_updated').text(i_updated);
    $('#n_nama').text(i_nama);

    var myImage = new Image(150, 150);
    myImage.src = i_foto;
    x = document.getElementById("a_foto");
    x.appendChild(myImage);
    $('#modal-detail-gas').modal('show');
    console.log(myImage);
  });

  $('#data-gas').on('click','.btn-stok-tambah',function(){
     row = table.row( $(this).closest('tr') ).data();
      console.log(row);
      $('input[name=t_id_g]').val(row[0]);
      $('input[name=t_nama]').val(row[2]);
      $('input[name=t_isi]').val(row[3]);

    $('#modal-tambah-stok').modal('show');
  });

  $('#data-gas').on('click','.btn-stok-kurang',function(){
     row = table.row( $(this).closest('tr') ).data();
      console.log(row);
      $('input[name=k_id_g]').val(row[0]);
      $('input[name=k_nama]').val(row[2]);
      $('input[name=k_isi]').val(row[3]);

    $('#modal-kurang-stok').modal('show');
  });
</script>
@endsection