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

class Pengiriman extends Controller
{
    public function data_pengiriman(Request $request){
        $data['title'] = "Data Pengiriman";
        $data['id'] = Auth::User()->id;
        $data['nama'] = Auth::User()->nama;
        $data['pesanan'] = M_Pemesanan::where('pemesanan.status_pemesanan','Pengiriman')->get();
        return view('Backend/data_pengiriman',$data);
    }
    public function detail_data_pengiriman(Request $request){
        $data['title'] = "Detail Data Pengiriman";
        $data['nama'] = Auth::User()->nama;
        $data['id'] = Auth::User()->id;
        $data['informasi'] = M_Informasi::where('informasi.id',1)->first();
        $info = M_Informasi::where('informasi.id',1)->first();
        $kota = M_Pemesanan::where('id_pemesanan',$request->id_pemesanan)
        ->join('users','users.id','=','pemesanan.id')
        ->join('customer','customer.id','=','users.id')
        ->join('kelurahan','kelurahan.id_kelurahan','=','customer.id_kelurahan')
        ->join('kecamatan','kecamatan.id_kecamatan','=','kelurahan.id_kecamatan')
        ->join('kota_kabupaten','kota_kabupaten.id_kota','=','kecamatan.id_kota')->first();
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
        return view('Backend/detail_data_pengiriman',$data);
    }
    public function selesai_kirim(Request $request){

    	$data=array(
				'status_pemesanan'=> "Konfirmasi Selesai",
			);

		M_Pemesanan::where('id_pemesanan','=',$request->id_pemesanan)->update($data);
		\Session::flash('msg_selesai_kirim','Pengiriman Selesai!');
		return Redirect::route('data_pengiriman');
    }
    public function batal_kirim(Request $request){

        $data=array(
                'status_pemesanan'=> "Diproses",
            );

        M_Pemesanan::where('id_pemesanan','=',$request->id_pemesanan)->update($data);
        \Session::flash('msg_batal_kirim','Pengiriman Dibatalkan!');
        return Redirect::route('data_pengiriman');
    }
}
?>