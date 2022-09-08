<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Models\M_Gas;
use App\Models\M_Customer;
use App\Models\User;
use App\Models\M_Kelurahan;
use App\Models\M_KotaKabupaten;
use Redirect;
use App\Models\M_Kecamatan;
use App\Models\M_DetailPemesanan;
use App\Models\M_Pemesanan;
use App\Models\M_HistoriGas;
use App\Models\M_Informasi;


class FrontEnd extends Controller
{
    public function index()
    {
     	$data['title'] = "Home";
     	$data['nama'] = Auth::User()->nama;
     	$data['id'] = Auth::User()->id;
     	$data['gas'] = M_Gas::get();
        $data['informasi'] = M_Informasi::where('informasi.id',1)->first();
     	return view('Frontend/customer_home',$data);
    }
    public function produk()
    {
        $data['title'] = "Produk";
        $data['nama'] = Auth::User()->nama;
        $data['id'] = Auth::User()->id;
        $data['gas'] = M_Gas::get();
        return view('Frontend/customer_produk',$data);
    }
    public function setting(Request $request)
    {
        $data['title'] = "Profile";
        $data['nama'] = Auth::User()->nama;
        $data['id'] = Auth::User()->id;
        $data['edit'] = M_Customer::where('customer.id',$request->id)
            ->join('kelurahan','kelurahan.id_kelurahan','=','customer.id_kelurahan')
            ->join('users','users.id','=','customer.id')
            ->join('kecamatan','kecamatan.id_kecamatan','=','kelurahan.id_kecamatan')
            ->join('kota_kabupaten','kecamatan.id_kota','=','kota_kabupaten.id_kota')->first();
            $data['kel'] =M_Kelurahan::get();
            $data['kota'] = M_KotaKabupaten::get();
            $data['kec'] = M_Kecamatan::get();
        return view('Frontend/customer_setting',$data);
    } 
    public function kecamatan(Request $request){
            $kec = M_Kecamatan::where('id_kota','=',$request->id_kota)->pluck('nama_kecamatan', 'id_kecamatan');
            return response()->json($kec);
        }
    public function kelurahan(Request $request){
            $kel = M_Kelurahan::where('id_kecamatan','=',$request->id_kecamatan)->pluck('nama_kelurahan', 'id_kelurahan');
            return response()->json($kel);
        }
    public function edit_customer(Request $request){
            $password = $request->password;

        if (! empty($password)) {
            
        $data = array(
            'id' => $request->id_login,
            'password' => bcrypt($request->password),
            'updated_at' => date('Y-m-d H:i:s'),
        );
        DB::table('users')->where('id','=',$request->id_login)->update($data);

        $data = array(  
                'id_customer'  => $request->id_cus,
                'nama_customer'=> $request->nama_cus,
                'nik_customer'=> $request->nik,
                'email_customer' => $request->email,
                'no_hp'=> $request->no_tlpn,
                'id_kelurahan'=> $request->kelurahan,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'alamat' => $request->alamat,
                'id'=>$request->id_login,
         );
        M_Customer::where('id_customer','=',$request->id_cus)->update($data);
        \Session::flash('msg_edit_cus',' Password & Data Customer Berhasil Diupdate!');
            return Redirect::route('home_customer');
        }else{

            $data = array(
            'id' => $request->id_login,
            'status' => "Aktif",
            'updated_at' => date('Y-m-d H:i:s'),
        );
        DB::table('users')->where('id','=',$request->id_login)->update($data);

            $data = array(
                'id_customer'     => $request->id_cus,
                'nama_customer'=> $request->nama_cus,
                'nik_customer'=> $request->nik,
                'email_customer' => $request->email,
                'no_hp'=> $request->no_tlpn,
                'id_kelurahan'=> $request->kelurahan,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'alamat' => $request->alamat,
                'id'=>$request->id_login,
         );
        M_Customer::where('id_customer','=',$request->id_cus)->update($data);
        \Session::flash('msg_edit_cus','Data Customer Berhasil Diupdate!');
            return Redirect::route('home_customer');
        }
    }
    public function pesan(Request $request){

        if ($request->jmlh>$request->stok) {
            \Session::flash('msg_stok_kurang','Stok Produk Tidak Mencukupi, Kurangi Jumlah Produk');
            return \Redirect::back();
        }else{

        $total = $request->harga * $request->jmlh;
        $no_invoice = date('d-m-Y').'-'.rand(1,99999).'';
        $data=array(
                    'no_invoice'=> $no_invoice,
                    'id_gas' => $request->id_gas,
                    'jumlah_beli'=> $request->jmlh, 
                    'sub_total'=> $total,
                );
                M_DetailPemesanan::insert($data);
                 \Session::flash('msg_simpan_pesanan','Data Customer Berhasil Disimpan!');
                return Redirect::route('form',$no_invoice);
        }
    }
    public function form_pemesanan(Request $request){
        $data['title'] = "Form Pemesanan";
        $data['nama'] = Auth::User()->nama;
        $data['id'] = Auth::User()->id;
        $data['gas'] = M_Gas::get();
        $kota = User::where('users.id',Auth::User()->id)->join('customer','customer.id','=','users.id')
        ->join('kelurahan','kelurahan.id_kelurahan','=','customer.id_kelurahan')
        ->join('kecamatan','kecamatan.id_kecamatan','=','kelurahan.id_kecamatan')
        ->join('kota_kabupaten','kota_kabupaten.id_kota','=','kecamatan.id_kota')->first();
        $data['informasi']= M_Informasi::where('informasi.id',1)->first();
        $info = M_Informasi::where('informasi.id',1)->first();
        $dtl = M_DetailPemesanan::where('detail_pemesanan.no_invoice',$request->no_invoice)
        ->join('gas','gas.id_gas','=','detail_pemesanan.id_gas')->get();

        $berat_total = 0;
        foreach ($dtl as $key => $value) {
            $berat_total += $value->berat;
        }

        $jarak = $kota->jarak;
        if ($berat_total>=1000) {
            $total_ongkir = 150000;
        }else if ($berat_total>=900) {
            $total_ongkir = ($berat_total*40)*$jarak;
        }else if ($berat_total>=800) {
            $total_ongkir = ($berat_total*45)*$jarak;
        }else if ($berat_total>=700) {
            $total_ongkir = ($berat_total*50)*$jarak;
        }else if ($berat_total>=600) {
            $total_ongkir = ($berat_total*55)*$jarak;
        }else if ($berat_total>=500) {
            $total_ongkir = ($berat_total*60)*$jarak;
        }else if ($berat_total>=400) {
            $total_ongkir = ($berat_total*70)*$jarak;
        }else if ($berat_total>=300) {
            $total_ongkir = ($berat_total*85)*$jarak;
        }else if ($berat_total>=200) {
            $total_ongkir = ($berat_total*100)*$jarak;
        }else if ($berat_total>=100) {
            $total_ongkir = ($berat_total*150)*$jarak;
        }else if ($berat_total>=50) {
            $total_ongkir = ($berat_total*200)*$jarak;
        }else if ($berat_total>=36) {
            $total_ongkir = ($berat_total*350)*$jarak;
        }else if ($berat_total>=24) {
            $total_ongkir = ($berat_total*450)*$jarak;
        }else if ($berat_total>=12) {
            $total_ongkir = ($berat_total*550)*$jarak;
        }else if ($berat_total==5.5) {
            $total_ongkir = ($berat_total*750)*$jarak;
        }

        $data['biaya_ongkir'] = $total_ongkir;
        $data['tgl'] = date('Y-m-d');
        $data['detail'] = M_DetailPemesanan::where('detail_pemesanan.no_invoice',$request->no_invoice)
        ->join('gas','gas.id_gas','=','detail_pemesanan.id_gas')->get();
        $data['inv'] = M_DetailPemesanan::where('detail_pemesanan.no_invoice',$request->no_invoice)
        ->join('gas','gas.id_gas','=','detail_pemesanan.id_gas')->first();
        return view('Frontend/form_pemesanan',$data);
    }
    public function update_pemesanan(Request $request){

        $gas = M_DetailPemesanan::where('id_detail_pemesanan','=',$request->id_detail)
        ->join('gas','gas.id_gas','=','detail_pemesanan.id_gas')->first();

        if ($request->jumlah>$gas->stok) {
            \Session::flash('msg_stok_kurang','Stok Produk Tidak Mencukupi, Kurangi Jumlah Produk');
            return \Redirect::back();
        }else{
        $harga = $request->sub_total / $request->old_jumlah;
        $total = $request->jumlah * $harga;

        $data=array(
                    'no_invoice'=> $request->no_invoice,
                    'id_gas' => $request->id_gas,
                    'jumlah_beli'=> $request->jumlah,
                    'sub_total'=> $total,
            );
            M_DetailPemesanan::where('id_detail_pemesanan','=',$request->id_detail)->update($data);
            \Session::flash('msg_edit_detail','Data Pemesanan Berhasil Diubah!');
            return Redirect::back();
        }
    }
    public function tambah_pemesanan(Request $request){

        if ($request->jumlah>$request->stok) {
            \Session::flash('msg_stok_kurang','Stok Produk Tidak Mencukupi, Kurangi Jumlah Produk');
            return \Redirect::back();
        }else{
            $gas = M_Gas::where('id_gas',$request->id_produk)->first();

            if ($request->jenis == 1) {

            $total = $gas->harga_refill * $request->jumlah;

            $data=array(
                        'no_invoice'=> $request->no_invoice,
                        'id_gas' => $request->id_produk,
                        'jumlah_beli'=> $request->jumlah,
                        'sub_total'=> $total,
                    );
                    M_DetailPemesanan::insert($data);
                     \Session::flash('msg_tambah_pesanan','Data Pemesanan Berhasil Ditambah!');
                    return Redirect::back();  
            }else if ($request->jenis == 2) {

                $total = $gas->harga * $request->jumlah;

                $data=array(
                            'no_invoice'=> $request->no_invoice,
                            'id_gas' => $request->id_produk,
                            'jumlah_beli'=> $request->jumlah,
                            'sub_total'=> $total,
                        );
                        M_DetailPemesanan::insert($data);
                         \Session::flash('msg_tambah_pesanan','Data Pemesanan Berhasil Ditambah!');
                        return Redirect::back();  
                }else{
                    \Session::flash('msg_tambah_gagal','Data Pemesanan Gagal Ditambah!');
                        return Redirect::back();
                }
            }
    }
    public function hapus_pemesanan(Request $request)
        {
            $data = M_DetailPemesanan::where('id_detail_pemesanan','=',$request->id_detail_pemesanan);
            $query = $data->first();
            $data->delete();
            \Session::flash('msg_hapus_pemesanan','Data Pemesanan Berhasil Dihapus!');
            return \Redirect::back();
        }
    public function buat_pemesanan(Request $request){
        if ($request->metode == "Cod") {

            $data=array(
                'no_invoice'=> $request->no_invoice,
                'tgl_pemesanan' => $request->tgl_pemesanan,
                'total_bayar'=> $request->total_bayar,
                'metode_pembayaran'=> "Bayar Ditempat",
                'bukti_bayar'=> "Bayar Ditempat",
                'status_pemesanan'=> "Diproses",
                'biaya_pengiriman' => $request->ongkir,
                'id'=> $request->id,
            );
            M_Pemesanan::insert($data);

            $psn = $request->id_detail;
            $new_stok = 0;

            for ($i=0; $i <count($psn) ; $i++) { 
                
                $data_pesan = M_DetailPemesanan::where('id_detail_pemesanan',$request->id_detail[$i])
                ->join('gas','gas.id_gas','=','detail_pemesanan.id_gas')->get();

                foreach ($data_pesan as $key => $value) {
                    $new_stok = $value->stok - $value->jumlah_beli;

                    $data=array(
                    'stok'=>$new_stok,
                );
                M_Gas::where('id_gas','=',$value->id_gas)->update($data);

                    $data=array(
                    'id_gas' => $value->id_gas,
                    'jumlah_gas'=>$value->jumlah_beli,
                    'status_gas' => 'Terjual',
                    'keterangan_gas' => "Produk Terjual",
                    'tgl_gas' => date('Y-m-d H:i:s'),
                    'bukti_pembelian' => $request->no_invoice,
                );
                M_HistoriGas::insert($data);
                }

            }

            \Session::flash('msg_buat_pesanan','Pemesanan Berhasil, Terima Kasih!');
            return Redirect::route('home_customer');

        }else if ($request->metode == "Transfer") {

            if (empty($request->bukti_bayar)) {
                 \Session::flash('msg_gagal_pesan','Silahkan Masukan Bukti Pembayaran!');
            return Redirect::back();
            }else{

                $photo = $request->file('bukti_bayar')->getClientOriginalName();
                $destination = base_path() .'/public/uploads';
                $request->file('bukti_bayar')->move($destination,$photo);

                    $data=array(
                        'no_invoice'=> $request->no_invoice,
                        'tgl_pemesanan' => $request->tgl_pemesanan,
                        'total_bayar'=> $request->total_bayar,
                        'metode_pembayaran'=> "Transfer",
                        'bukti_bayar'=> $photo,
                        'status_pemesanan'=> "Diproses",
                        'biaya_pengiriman' => $request->ongkir,
                        'id'=> $request->id,
                    );
                    M_Pemesanan::insert($data);

                    $psn = $request->id_detail;
                    $new_stok = 0;

                    for ($i=0; $i <count($psn) ; $i++) { 
                        
                        $data_pesan = M_DetailPemesanan::where('id_detail_pemesanan',$request->id_detail[$i])
                        ->join('gas','gas.id_gas','=','detail_pemesanan.id_gas')->get();

                        foreach ($data_pesan as $key => $value) {
                            $new_stok = $value->stok - $value->jumlah_beli;

                            $data=array(
                            'stok'=>$new_stok,
                        );
                        M_Gas::where('id_gas','=',$value->id_gas)->update($data);

                            $data=array(
                            'id_gas' => $value->id_gas,
                            'jumlah_gas'=>$value->jumlah_beli,
                            'status_gas' => 'Terjual',
                            'keterangan_gas' => "Produk Terjual",
                            'tgl_gas' => date('Y-m-d H:i:s'),
                            'bukti_pembelian' => $request->no_invoice,
                        );
                        M_HistoriGas::insert($data);
                        }
                    }
            }

            \Session::flash('msg_buat_pesanan','Pemesanan Berhasil, Terima Kasih!');
            return Redirect::route('home_customer');
        }else{
            \Session::flash('msg_gagal_pesan','Silahkan Pilih Metode Pembayaran!');
            return Redirect::back();
        }
    }
    public function cancel_pemesanan(Request $request){
                
        $data = M_DetailPemesanan::where('no_invoice','=',$request->no_invoice);
        $query = $data->get();
        $data->delete();
        \Session::flash('msg_cancel_pemesanan','Pemesanan Dibatalkan!');
        return Redirect::route('home_customer');
    }
    public function data_pesanan(Request $request){
        $data['title'] = "Data Pemesanan";
        $data['nama'] = Auth::User()->nama;
        $data['id'] = Auth::User()->id;
        $data['pesanan'] = M_Pemesanan::where('pemesanan.id',$request->id)->get();
        return view('Frontend/pesanan_customer',$data);
    }
    public function detail_data_pesanan(Request $request){
        $data['title'] = "Detail Data Pemesanan";
        $data['nama'] = Auth::User()->nama;
        $data['id'] = Auth::User()->id;
        $kota = User::where('users.id',Auth::User()->id)->join('customer','customer.id','=','users.id')
        ->join('kelurahan','kelurahan.id_kelurahan','=','customer.id_kelurahan')
        ->join('kecamatan','kecamatan.id_kecamatan','=','kelurahan.id_kecamatan')
        ->join('kota_kabupaten','kota_kabupaten.id_kota','=','kecamatan.id_kota')->first();
        $data['informasi'] = M_Informasi::where('informasi.id',1)->first();
        $info = M_Informasi::where('informasi.id',1)->first();
        $dtl = M_DetailPemesanan::where('detail_pemesanan.no_invoice',$request->no_invoice)
        ->join('gas','gas.id_gas','=','detail_pemesanan.id_gas')->get();
        $data['pesanan'] = M_Pemesanan::where('id_pemesanan',$request->id_pemesanan)
        ->join('users','users.id','=','pemesanan.id')
        ->join('customer','customer.id','=','users.id')
        ->join('kelurahan','kelurahan.id_kelurahan','=','customer.id_kelurahan')
        ->join('kecamatan','kecamatan.id_kecamatan','=','kelurahan.id_kecamatan')
        ->join('kota_kabupaten','kota_kabupaten.id_kota','=','kecamatan.id_kota')->first();
        $data['detail'] = M_Pemesanan::where('pemesanan.id_pemesanan',$request->id_pemesanan)
        ->join('detail_pemesanan','detail_pemesanan.no_invoice','=','pemesanan.no_invoice')
        ->join('gas','gas.id_gas','=','detail_pemesanan.id_gas')->get();
        return view('Frontend/detail_pesanan_customer',$data);
    }
    public function konfirmasi_selesai(Request $request){
        $id = Auth::User()->id;

        $data=array(
                'status_pemesanan'=> "Selesai",
            );

        M_Pemesanan::where('id_pemesanan','=',$request->id_pemesanan)->update($data);
        \Session::flash('msg_selesai','Terima Kasih!');
        return Redirect::route('data_pesanan',$id);
    }
    public function cetak_data_pesanan(Request $request){
        $data['title'] = "Bukti Pemesanan";
        $data['nama'] = Auth::User()->nama;
        $data['id'] = Auth::User()->id;
        $data['informasi'] = M_Informasi::where('informasi.id',1)->first();
        $data['pesanan'] = M_Pemesanan::where('id_pemesanan',$request->id_pemesanan)
        ->join('users','users.id','=','pemesanan.id')
        ->join('customer','customer.id','=','users.id')
        ->join('kelurahan','kelurahan.id_kelurahan','=','customer.id_kelurahan')
        ->join('kecamatan','kecamatan.id_kecamatan','=','kelurahan.id_kecamatan')
        ->join('kota_kabupaten','kota_kabupaten.id_kota','=','kecamatan.id_kota')->first();
        $data['detail'] = M_Pemesanan::where('pemesanan.id_pemesanan',$request->id_pemesanan)
        ->join('detail_pemesanan','detail_pemesanan.no_invoice','=','pemesanan.no_invoice')
        ->join('gas','gas.id_gas','=','detail_pemesanan.id_gas')->get();
        return view('Frontend/cetak_data_pemesanan',$data);
    }
   function logout(){
    	Auth::logout();
    	return \Redirect::to('/');
    }
}
