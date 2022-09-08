@extends('layouts.pengiriman')
@section('css')
<link rel="stylesheet" href="{{ asset('plugins/morris/morris.css') }}">
<link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
@endsection

@section('content')
  <section class="content-header">
    <ol class="breadcrumb">
      <li><a href="{{ route('home_penjualan') }}"><i class="fa fa-home"></i> Home Penngiriman</a></li>
    </ol>
  </section>
  <section class="content">
    <br/>
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-check"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Jumlah Pengiriman</span>
              <span class="info-box-number">{{ $pengiriman }}</span>
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