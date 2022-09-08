@extends('layouts.customer')
@section('css')

@endsection

@section('content')
      <section class="content-header">
        <h1>
          Selamat Datang
          <small>{{ $nama }}</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{ route('home_customer') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        @if(\Session::has('msg_buat_pesanan'))
           <h5> <div class="alert alert-success">
              {{ \Session::get('msg_buat_pesanan')}}
            </div></h5>
            @endif
          @if(\Session::has('msg_cancel_pemesanan'))
           <h5> <div class="alert alert-success">
              {{ \Session::get('msg_cancel_pemesanan')}}
            </div></h5>
            @endif
          <div class="col-md-12">
            <div class="box box-widget">
              <div class="box-header with-border">
                <div class="user-block">
                  
                  <span class="username"><a href="{{ route('home_customer') }}">Informasi</a></span>
                  <span class="description">Admin, PT. GASINDO CIREBON PRIMA</span>
                </div>
                <!-- /.user-block -->
                <div class="box-tools"> 
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
                <!-- /.box-tools -->
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <!-- post text -->
                <h4>{{ $informasi->judul_informasi }}</h4><br/>
                <p>{{ $informasi->informasi }}</p>


              </div>
              <!-- /.box-footer -->
            </div>
          </div>
      </section>
      <!-- /.content -->
 @endsection

@section('javascript')

@endsection
