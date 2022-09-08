@extends('layouts.index')
@section('css')

@endsection

@section('content')
      <section class="content-header">
        <h1>
          Produk
          <small></small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Produk</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">

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
	                  <b>Harga Isi Ulang</b> <a class="pull-right">{{ $value->harga_refill }}</a>
	                </li>
	                <li class="list-group-item">
	                  <b>Harga Isi + Tabung</b> <a class="pull-right">{{ $value->harga }}</a>
	                </li>
	                <li class="list-group-item">
	                  <b>Stok</b> <a class="pull-right">{{ $value->stok }}</a>
	                </li>
	              </ul>

	              <a href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modal-cek"><i class="fa fa-shopping-cart"> <b>Pesan</b></i></a>
	            </div>
	          </div>
	      	</div>
		    @endforeach
      	</div>

        <!-- /.box -->
      <div class="modal fade" id="modal-cek" role="dialog">
	    <div class="modal-dialog">
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Apakah sudah memiliki account?</h4>
	        </div>
	        <div class="modal-body">
		        
	        <div class="modal-footer">
	          <center>
		          <a href="{{ route('form_login') }}"><button class="btn btn-success">Sudah</button></b></a> &nbsp; &nbsp;
		          <a href="{{ route('register') }}"><button class="btn btn-default">Belum</button></b></a>
		      	</center>
	        </div>
	      </div>
	    </div>
	  </div>
      </section>
      <!-- /.content -->
 @endsection

@section('javascript')

@endsection
