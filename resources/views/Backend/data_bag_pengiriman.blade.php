@extends('layouts.admin')
@section('css')
  <link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
@endsection

@section('content')
    <section class="content-header">
      <ol class="breadcrumb">
        <li><a href="{{ route('home_admin') }}"><i class="fa fa-home"></i> Home</a></li>
        <li class="active">Data Bagian Pengiriman</li>
      </ol>
      <br/>
    </section>
    <section class="content">
            @if(\Session::has('msg_simpan_penjualan'))
           <h5> <div class="alert alert-info">
              {{ \Session::get('msg_simpan_penjualan')}}
            </div></h5>
            @endif
            @if(\Session::has('msg_hapus_penjualan'))
           <h5> <div class="alert alert-danger">
              {{ \Session::get('msg_hapus_penjualan')}}
            </div></h5>
            @endif
            @if(\Session::has('msg_edit_penjualan'))
           <h5> <div class="alert alert-warning">
              {{ \Session::get('msg_edit_penjualan')}}
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
                <h3 class="box-title">Data Petugas Bagian Pengiriman</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#modal-tambah-bag-penjualan"><i class="fa fa-user-plus"> Tambah Petugas</i></button>
                </div>
              </div>
              <div class="box-body">
                 <table class="table table-bordered table-striped" id="data-bag-penjualan">
            <thead>
              <tr>
                <th width="25">ID</th>
                <th width="125">Nama</th>
                <th width="100">Username</th>
                <th width="75">No Telpon</th>
                <th>Dibuat</th>
                <th>Last Update</th>
                <th width="160">Aksi</th>
              </tr>
            </thead>
              <tbody>
                 @foreach($penjualan as $key => $value)
                    <tr>
                      <td>{{ $value->id }}</td>
                      <td>{{ $value->nama }}</td>
                      <td>{{ $value->username }}</td>
                      <td>{{ $value->no_tlpn }}</td>
                      <td>{{ $value->created_at }}</td>
                      <td>{{ $value->updated_at }}</td>
                      <td>
                        <button class="btn btn-success btn-edit-bag-penjualan"><i class="fa fa-edit"> Edit</i></button> &nbsp;<a href="{{ route('hapus_penjualan',$value->id) }}"><button class=" btn btn-danger" onclick="return confirm('apakah anda ingin menghapus data ini ?')"><i class="fa fa-trash"> Hapus</i></button></a>
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
   <div class="modal fade" id="modal-tambah-bag-penjualan" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Form Tambah Data Petugas Pengiriman</h4>
        </div>
        <div class="modal-body">
          <form action="{{ route('simpan_penjualan') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
          <div class="form-group has-feedback">
            <input type="text" name="nama" class="form-control" placeholder="Nama" required>
          </div>
           <div class="form-group has-feedback">
            <input type="text" name="username" class="form-control" placeholder="Username" required="">
          </div>
           <div class="form-group has-feedback">
            <input type="password" name="password" class="form-control" placeholder="Password" required="">
          </div>
           <div class="form-group has-feedback">
            <input type="number" name="no_tlpn" class="form-control" placeholder="No Telepon/WhatsApp" required="">
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
  <div class="modal fade" id="modal-edit-bag-penjualan" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Form Edit Data Petugas Pengiriman/h4>
        </div>
        <div class="modal-body">
          <form action="{{ route('update_penjualan') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
          <div class="form-group has-feedback">
            <input type="text" name="id" readonly class="form-control" placeholder=" ID">
          </div>
          <div class="form-group has-feedback">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" placeholder=" Masukan Nama">
          </div>
           <div class="form-group has-feedback">
            <label>Username :</label>
            <input type="text" name="username" class="form-control" placeholder="Masukan Username">
          </div>
           <div class="form-group has-feedback">
            <label>Password:</label>
            <input type="password" name="password" class="form-control" placeholder=" Masukan Password Baru">
          </div>
           <div class="form-group has-feedback">
            <input type="hidden" name="created_at" class="form-control" placeholder=" Masukan Password Baru">
          </div>
           <div class="form-group has-feedback">
            <label>No Telepon/WhatsApp</label>
            <input type="number" name="no_tlpn" class="form-control" placeholder="Masukan No Telepon/WhatsApp">
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
@endsection

@section('javascript')
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script type="text/javascript">
  var table = $('#data-bag-penjualan').DataTable();

  $('#data-bag-penjualan').on('click','.btn-edit-bag-penjualan',function(){
    row = table.row( $(this).closest('tr') ).data();
    console.log(row);
    $('input[name=id]').val(row[0]);
    $('input[name=nama]').val(row[1]);
    $('input[name=username]').val(row[2]);
    $('input[name=no_tlpn]').val(row[3]);
    $('input[name=created_at]').val(row[4]);
    $('#modal-edit-bag-penjualan').modal('show');
  });
  
  $('#modal-tambah-bag-penjualan').on('show.bs.modal',function(){
    $('input[name=id]').val('');
    $('input[name=nama]').val('');
    $('input[name=username]').val('');
    $('input[name=no_tlpn]').val('');
  });
</script>
@endsection