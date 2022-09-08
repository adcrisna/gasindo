@extends('layouts.admin')
@section('css')
  <link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
@endsection

@section('content')
  <section class="content-header">
    <ol class="breadcrumb">
      <li><a href="{{ route('home_admin') }}"><i class="fa fa-home"></i> Home</a></li>
      <li><a href="{{ route('data_kota') }}"> Data Kota/Kabupaten</a></li>
      <li><a href="{{ route('data_kec',$kec->id_kota) }}"> Data Kecamatan </a></li>
      <li class="active">Data Kelurahann</li>
    </ol>
    <br/>
  </section>
  <section class="content">
           @if(\Session::has('msg_simpan_kel'))
           <h5> <div class="alert alert-info">
              {{ \Session::get('msg_simpan_kel')}}
            </div></h5>
            @endif
            @if(\Session::has('msg_hapus_kel'))
           <h5> <div class="alert alert-danger">
              {{ \Session::get('msg_hapus_kel')}}
            </div></h5>
            @endif
            @if(\Session::has('msg_edit_kel'))
           <h5> <div class="alert alert-warning">
              {{ \Session::get('msg_edit_kel')}}
            </div></h5>
            @endif
    <div class="row">
      <div class="col-xs-12">
          <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">Data Kelurahan: {{ $kec->nama_kecamatan }}</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#modal-form-tambah-kel"><i class="fa fa-user-plus"> Tambah</i></button>
                </div>
              </div>
              <div class="box-body">
                <table class="table table-bordered table-striped" id="data-kel">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Nama Kelurahan</th>
                          <th>Nama Kecamatan</th>
                          <th>Nama Kota</th>
                          <th>Aksi</th>       
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($kel as $key => $value)
                        <tr>
                          <td>{{ $value->id_kelurahan }}</td>
                          <td>{{ $value->nama_kelurahan }}</td>
                          <td>{{ $value->nama_kecamatan }}</td>
                          <td>{{ $value->nama_kota }}</td>
                          <td width="330px">
                            <a href="{{ route('data_cust',$value->id_kelurahan) }}" class="btn btn-primary "><i class="fa fa-eye"> Lihat Data Customer</i></a>&nbsp;
                            <button class="btn btn-success btn-edit-kel"><i class="fa fa-edit"> Edit</i></button> &nbsp;<a href="{{ route('hapus_kel',$value->id_kelurahan) }}"><button class=" btn btn-danger" onclick="return confirm('apakah anda ingin menghapus data ini ?')" ><i class="fa fa-trash"> Hapus</i></button></a> 
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
  <div class="modal fade" id="modal-form-tambah-kel" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Form Tambah Kecamatan</h4>
        </div>
        <div class="modal-body">
           <form action="{{ route('simpan_kel') }}" method="post">
            {{ csrf_field() }}

          <div class="form-group has-feedback">
            <input type="text" name="nama_kel" class="form-control" placeholder="Nama Kelurahan">
          </div>
          <input type="hidden" name="id_keca" value="{{ $kec->id_kecamatan }}">
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
    <div class="modal fade" id="modal-form-edit-kel" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Form Edit Kecamatan</h4>
        </div>
        <div class="modal-body">
           <form action="{{ route('edit_kel') }}" method="post">
            {{ csrf_field() }}
          <div class="form-group has-feedback">
            <input type="text" name="id_kel"  readonly class="form-control" placeholder=" ID Kelurahan">
          </div>
          <div class="form-group has-feedback">
            <input type="text" name="nama_kel" class="form-control" placeholder="Nama Kelurahan">
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
  var table = $('#data-kel').DataTable();

  $('#data-kel').on('click','.btn-edit-kel',function(){
    row = table.row( $(this).closest('tr') ).data();
    console.log(row);
    $('input[name=id_kel]').val(row[0]);
    $('input[name=nama_kel]').val(row[1]);
    $('input[name=create]').val(row[3]);
    $('#modal-form-edit-kel').modal('show');
  });

  $('#modal-form-tambah-kel').on('show.bs.modal',function(){
    $('input[name=nama_kel]').val('');
    $('input[name=id_kec]').val('');
  });
</script>
@endsection