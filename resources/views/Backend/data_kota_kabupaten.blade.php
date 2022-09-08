@extends('layouts.admin')
@section('css')
  <link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
@endsection

@section('content')
  <section class="content-header">
    <ol class="breadcrumb">
      <li><a href="{{ route('home_admin') }}"><i class="fa fa-home"></i> Home</a></li>
      <li class="active">Data Kota/Kabupaten</li>
    </ol>
    <br/>
  </section>
  <section class="content">
          @if(\Session::has('msg_simpan_kota'))
           <h5> <div class="alert alert-info">
              {{ \Session::get('msg_simpan_kota')}}
            </div></h5>
            @endif
            @if(\Session::has('msg_hapus_kota'))
           <h5> <div class="alert alert-danger">
              {{ \Session::get('msg_hapus_kota')}}
            </div></h5>
            @endif
            @if(\Session::has('msg_edit_kota'))
           <h5> <div class="alert alert-warning">
              {{ \Session::get('msg_edit_kota')}}
            </div></h5>
            @endif
    <div class="row">
      <div class="col-xs-12">
          <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Data Kota/Kabupaten</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#modal-form-tambah-kota"><i class="fa fa-user-plus"> Tambah</i></button>
                  </div>
                </div>
                  <div class="box-body">
                      <table class="table table-bordered table-striped" id="data-kota">
                      <thead>
                        <tr>
                          <th width="100">ID Kota/Kabupaten</th>
                          <th>Nama Kota/Kabupaten</th>
                          <th>Provinsi</th>  
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($kota as $key => $value)
                        <tr>
                          <td width="100">{{ $value->id_kota }}</td>
                          <td>{{ $value->nama_kota }}</td>
                          <td>{{ $value->provinsi }}</td>
                          <td width="330px">
                            <a href="{{ route('data_kec',$value->id_kota) }}">
                            <button class="btn btn-primary"><i class="fa fa-eye"> Lihat Kecamatan</i></button></a>&nbsp;<button class="btn btn-success btn-edit-kota"><i class="fa fa-edit"> Edit</i></button> &nbsp;<a href="{{ route('hapus_kota',$value->id_kota) }}"><button class=" btn btn-danger" onclick="return confirm('apakah anda ingin menghapus data ini ?')"><i class="fa fa-trash"> Hapus</i></button></a>
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
  <div class="modal fade" id="modal-form-tambah-kota" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Form Tambah Kota/Kabupaten</h4>
        </div>
        <div class="modal-body">
           <form action="{{ route('simpan_kota') }}" method="post">
            {{ csrf_field() }}
          <div class="form-group has-feedback">
            <input type="text" name="nama_kota" class="form-control" placeholder="Nama Kota/Kabupaten">
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
    <div class="modal fade" id="modal-form-edit-kota" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Form Edit Jurusan</h4>
        </div>
        <div class="modal-body">
           <form action="{{ route('edit_kota') }}" method="post">
            {{ csrf_field() }}
          <div class="form-group has-feedback">
            <input type="text" name="id_kota"  readonly class="form-control" placeholder=" ID Kota/Kabupaten ">
          </div>
          <div class="form-group has-feedback">
            <input type="text" name="nama_kota" class="form-control" placeholder="Nama Kota">
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
@endsection

@section('javascript')
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script type="text/javascript">
  var table = $('#data-kota').DataTable();

  $('#data-kota').on('click','.btn-edit-kota',function(){
    row = table.row( $(this).closest('tr') ).data();
    console.log(row);
    $('input[name=id_kota]').val(row[0]);
    $('input[name=nama_kota]').val(row[1]);
    $('input[name=create]').val(row[3]);
    $('#modal-form-edit-kota').modal('show');
  });
  $('#modal-form-tambah-kota').on('show.bs.modal',function(){
    $('input[name=id_kota]').val('');
    $('input[name=nama_kota]').val('');
  });
</script>
@endsection