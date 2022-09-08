<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\M_Kelurahan;
use App\Models\M_Kecamatan;
use App\Models\M_KotaKabupaten;
use Redirect;
use Auth;

class Kelurahan extends Controller
{
    public function index()
		{
			$request = request();
			$data['kec'] = M_Kecamatan::where('id_kecamatan',$request->id_kecamatan)
			->join('kota_kabupaten','kecamatan.id_kota','=','kota_kabupaten.id_kota')->first();
			$data['title'] = 'Data Kelurahan';
			$data['nama'] = Auth::User()->nama;
			$data['id'] = Auth::User()->id;
			$data['kel'] = M_Kelurahan::where('kelurahan.id_kecamatan',$request->id_kecamatan)
			->join('kecamatan','kecamatan.id_kecamatan','=','kelurahan.id_kecamatan')
			->join('kota_kabupaten','kecamatan.id_kota','=','kota_kabupaten.id_kota')->get();
			return view('Backend/data_kelurahan',$data);
		}
		public function simpan_kelurahan(Request $request)
		{
			$kel = M_Kecamatan::where('id_kecamatan',$request->id_kecamatan)->first();

			$data=array(
				'nama_kelurahan'=>$request->nama_kel,
				'id_kecamatan'=>$request->id_keca,
			);
			M_Kelurahan::insert($data);
			\Session::flash('msg_simpan_kel','Data Kelurahan Berhasil Ditambah!');
			return Redirect::route('data_kel',$data['id_kecamatan']);
		}
		public function hapus_kelurahan(Request $request)
		{
			$data = M_Kelurahan::where('id_kelurahan','=',$request->id_kelurahan);
			$query = $data->first();
			$data->delete();
	        \Session::flash('msg_hapus_kel','Data Kelurahan Berhasil Dihapus!');
				return \Redirect::back();
		}
		public function edit_kelurahan(Request $request)
		{
			$data=array(
				'id_kelurahan'=>$request->id_kel,
				'nama_kelurahan'=>$request->nama_kel,

			);
			M_Kelurahan::where('id_kelurahan','=',$request->id_kel)->update($data);
			\Session::flash('msg_edit_kel','Data kelurahan Berhasil Diupdate!');
			return Redirect::back();
		}
}
?>