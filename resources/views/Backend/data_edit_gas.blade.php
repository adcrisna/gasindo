@extends('layouts.gudang')
@section('css')
  <link rel="stylesheet" href="{{ asset('plugins/datatables/dataTables.bootstrap.css') }}">
@endsection

@section('content')
    <section class="content-header">
      <ol class="breadcrumb">
        <li><a href="{{ route('home_admin') }}"><i class="fa fa-home"></i> Home</a></li>
      <li><a href="{{ route('data_gas') }}">Data GAS</a></li>
      <li class="active">Edit Data Gas</li>
      </ol>
      <br/>
    </section>
    <section class="content">
    <div class="row">
      <div class="col-xs-12">
          <div class="box box-danger">
              <div class="box-header">
                <h3 class="box-title">FORM UPDATE DATA GAS</h3>
                <div class="box-tools pull-right">
                <a href="{{ route('data_gas') }}"><button class="btn btn-warning"
                        ><i class="fa fa-sign-out"> Kembali</i></button></a>
              </div>
              <div class="box-body">
        <form action="{{ route('edit_gas') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
        <div class="form-row">
          <div class="col-md-6">
          <div class="form-group has-feedback">
            <label>ID GAS :</label>
            <input type="text"  name="id_gas" class="form-control" value="{{ $edit->id_gas }}"  readonly>
          </div>
          </div>
         <div class="col-md-6">
         <div class="form-group has-feedback">
            <label>GAS :</label>
            <input type="text"  name="nama" class="form-control" value="{{ $edit->nama_gas }}" required>
          </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col-md-6">
          <div class="form-group has-feedback">
            <label>Foto :</label>
            <img width="100px" src="{{ asset('uploads/'.$edit->foto_gas) }}">
            <input type="hidden"  name="foto" value="{{ $edit->foto_gas }}" class="form-control">
            <input type="file"  name="foto_gas" class="form-control">
          </div>
          </div>
        <div class="form-row">
          <div class="col-md-6">
          <div class="form-group has-feedback">
            <label>Harga Isi Ulang :</label>
            <input type="number"  name="harga_refill" class="form-control" value="{{ $edit->harga_refill }}" required>
          </div>
          </div>
          <div class="col-md-6">
          <div class="form-group has-feedback">
            <label>Harga isi + Tabung :</label>
            <input type="number" name="harga" class="form-control" value="{{ $edit->harga }}" required>
          </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col-md-6">
          <div class="form-group has-feedback">
            <input type="hidden"  name="id" class="form-control" value="{{ $edit->id }}" readonly>
          </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col-md-6">
          <div class="form-group has-feedback">
            <label>Berat:</label>
            <input type="number" name="berat" class="form-control" value="{{ $edit->berat }}" required>
          </div>
          </div>
          <div class="col-md-6">
          <div class="form-group has-feedback">
            <label>Stok:</label>
            <input type="number"  name="stok" class="form-control" value="{{ $edit->stok }}" readonly>
          </div>
          </div>
        </div>
          <div class="row">
            <div class="col-xs-2 col-xs-offset-5">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Update</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
</section>
  @endsection

@section('javascript')
<script>

</script>
@endsection