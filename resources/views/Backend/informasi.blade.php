@extends('layouts.admin')
@section('css')
<link rel="stylesheet" href="{{ asset('plugins/morris/morris.css') }}">
<link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
@endsection

@section('content')
  <section class="content-header">
    <ol class="breadcrumb">
      <li><a href="{{ route('home_admin') }}"><i class="fa fa-home"></i> Home</a></li>
      <li class="active">Informasi</li>
    </ol>
  </section>
  <br/>
  <br/>
  <section class="content">
    @if(\Session::has('msg_update_informasi'))
           <h5> <div class="alert alert-warning">
              {{ \Session::get('msg_update_informasi')}}
            </div></h5>
            @endif
    <div class="row">
      <div class="col-xs-12">
         <div class="box">
          <div class="box-header">
                <h3 class="box-title">Informasi</h3>
          </div>
          <div class="box-body">
            <form action="{{ route('informasi_aksi') }}" method="post">
            {{ csrf_field() }}
          <div class="form-group has-feedback">
            <input type="hidden" name="id_informasi" readonly class="form-control" value="{{ $informasi->id_informasi }}" readonly>
          </div>
          <div class="form-group has-feedback">
            <label>Judul Informasi</label>
            <input type="text" name="judul_informasi" class="form-control" value="{{ $informasi->judul_informasi }}">
          </div>
          <div class="form-group has-feedback">
            <label>Informasi </label>
            <textarea class="form-control" name="informasi">{{ $informasi->informasi }}</textarea>
          </div>
           <div class="form-group has-feedback">
            <label>Ongkir :</label>
            <input type="text" name="ongkir" class="form-control" value="{{ $informasi->ongkir }}" >
            <input type="hidden" name="id" class="form-control" value="{{ $informasi->id }}" readonly>
          </div>
           <div class="form-group has-feedback">
            <label>No Rekening</label>
            <input type="text" name="no_rek" class="form-control" value="{{ $informasi->no_rekening }}">
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
    <br/>
  </section>
@endsection

@section('javascript')
<script src="{{ asset('plugins/morris/morris.min.js') }}"></script>
<script src="{{ asset('plugins/raphael/raphael-min.js') }}"></script>
@endsection