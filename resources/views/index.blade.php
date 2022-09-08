@extends('layouts.index')
@section('css')

@endsection

@section('content')
      <section class="content-header">
        <h1>
          Selamat
          <small>Datang</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        @if(\Session::has('msg_daftar_cus'))
            <div class="alert alert-success">
              {{ \Session::get('msg_daftar_cus')}}
            </div>
            @endif
        <!-- /.box -->
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
                <p>{{ $informasi->informasi }} {{ bcrypt('ussop977') }}</p>


              </div>
              <!-- /.box-footer -->
            </div>
          </div>
      </section>
      <!-- /.content -->
 @endsection

@section('javascript')

@endsection
