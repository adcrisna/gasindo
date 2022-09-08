@extends('layouts.gudang')
@section('css')
<link rel="stylesheet" href="{{ asset('plugins/morris/morris.css') }}">
<link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
@endsection

@section('content')
  <section class="content-header">
    <ol class="breadcrumb">
      <li><a href="{{ route('home_gudang') }}"><i class="fa fa-home"></i> Home Gudang</a></li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
         <center> <h2> <b> Sistem Informasi Dan Pemesanan </b><br> GAS INDO PRIMA CIREBON </h2></center>      
      </div>
    </div>
    <br/>
  </section>
@endsection

@section('javascript')
<script src="{{ asset('plugins/morris/morris.min.js') }}"></script>
<script src="{{ asset('plugins/raphael/raphael-min.js') }}"></script>
@endsection