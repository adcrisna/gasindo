@extends('layouts.admin')
@section('css')
  <link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
@endsection

@section('content')
  <section class="content-header">
    <ol class="breadcrumb">
      <li><a href="{{ route('home_admin') }}"><i class="fa fa-home"></i> Home</a></li>
      <li><a href="{{ route('data_kota') }}"> Data Kota/Kabupaten</a></li>
      <li class="active">Data Kecamatan</li>
    </ol>
    <br/>
  </section>
  <section class="content">
           @if(\Session::has('msg_simpan_kec'))
           <h5> <div class="alert alert-info">
              {{ \Session::get('msg_simpan_kec')}}
            </div></h5>
            @endif
            @if(\Session::has('msg_hapus_kec'))
           <h5> <div class="alert alert-danger">
              {{ \Session::get('msg_hapus_kec')}}
            </div></h5>
            @endif
            @if(\Session::has('msg_edit_kec'))
           <h5> <div class="alert alert-warning">
              {{ \Session::get('msg_edit_kec')}}
            </div></h5>
            @endif
    <div class="row">
      <div class="col-xs-12">
          <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Data Kecamatan: {{ $kota->nama_kota }}</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#modal-form-tambah-kec"><i class="fa fa-user-plus"> Tambah</i></button>
                </div>
              </div>
              <div class="box-body">
                <table class="table table-bordered table-striped" id="data-kec">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Nama Kecamatan</th>
                          <th>Jarak</th>
                          <th>Nama Kota/Kabupaten</th>
                          <th>Provinsi</th>
                          <th>Aksi</th>       
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($kec as $key => $value)
                        <tr>
                          <td>{{ $value->id_kecamatan }}</td>
                          <td>{{ $value->nama_kecamatan }}</td>
                          <td>{{ $value->jarak }}</td>
                          <td>{{ $value->nama_kota }}</td>
                          <td>{{ $value->provinsi }}</td>
                          <td width="330px">
                            <a href="{{ route('data_kel',$value->id_kecamatan,) }}" class="btn btn-primary "><i class="fa fa-eye"> Lihat Data Kelurahan</i></a>&nbsp;<button class="btn btn-success btn-edit-kec"><i class="fa fa-edit"> Edit</i></button> &nbsp;<a href="{{ route('hapus_kec',$value->id_kecamatan) }}"><button class=" btn btn-danger" onclick="return confirm('apakah anda ingin menghapus data ini ?')" ><i class="fa fa-trash"> Hapus</i></button></a> 
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
  <div class="modal fade" id="modal-form-tambah-kec" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Form Tambah Kecamatan</h4>
        </div>
        <div class="modal-body">
           <form action="{{ route('simpan_kec') }}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="id_kota" value="{{ $kota->id_kota }}">
          <div class="form-group has-feedback">
            <input type="text" name="nama_kec" class="form-control" placeholder="Nama Kecamatan">
          </div>
          <div class="form-group has-feedback">
            <input type="number" name="jarak" class="form-control" placeholder="Jarak Kecamatan">
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
    <div class="modal fade" id="modal-form-edit-kec" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Form Edit Kecamatan</h4>
        </div>
        <div class="modal-body">
           <form action="{{ route('edit_kec') }}" method="post">
            {{ csrf_field() }}
          <div class="form-group has-feedback">
            <input type="text" name="id_kec"  readonly class="form-control" placeholder=" ID Kecamatan">
          </div>
          <div class="form-group has-feedback">
            <input type="text" name="nama_kec" class="form-control" placeholder="Nama Kecamatan">
          </div>
          <div class="form-group has-feedback">
            <input type="number" name="jarak" class="form-control" placeholder="Jarak Kecamatan">
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
  var table = $('#data-kec').DataTable();

  $('#data-kec').on('click','.btn-edit-kec',function(){
    row = table.row( $(this).closest('tr') ).data();
    console.log(row);
    $('input[name=id_kec]').val(row[0]);
    $('input[name=nama_kec]').val(row[1]);
    $('input[name=jarak]').val(row[2]);
    $('input[name=create]').val(row[4]);
    $('#modal-form-edit-kec').modal('show');
  });

  $('#modal-form-tambah-kec').on('show.bs.modal',function(){
    $('input[name=id_kec]').val('');
    $('input[name=nama_kec]').val('');
    $('input[name=jarak]').val('');
  });
</script>
@endsection