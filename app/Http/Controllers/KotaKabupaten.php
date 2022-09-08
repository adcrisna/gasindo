<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Models\M_KotaKabupaten;
use Redirect;

class KotaKabupaten extends Controller
{
   	public function index()
		{
			$data['title'] = 'Data Kota/Kabupaten';
			$data['kota'] = M_KotaKabupaten::get();
			$data['nama'] = Auth::User()->nama;
			$data['id'] = Auth::User()->id;
			return view('Backend/data_kota_kabupaten',$data);
		}
		public function simpan_data_kota(Request $request)
		{
			$data=array(
				'nama_kota'=> $request->nama_kota,
				'provinsi' => 'Jawa Barat',
			);
			M_KotaKabupaten::insert($data);
			\Session::flash('msg_simpan_kota','Data Kota/Kabupaten Berhasil Ditambah!');
			return Redirect::route('data_kota');
		}
		public function hapus_kota(Request $request)
		{
			$data = M_KotaKabupaten::where('id_kota','=',$request->id_kota);
			$query = $data->first();
			$data->delete();
	        \Session::flash('msg_hapus_kota','Data Kota Berhasil Dihapus!');
				return \Redirect::back();
		}
		public function edit_kota(Request $request)
		{

			$data=array(
				'id_kota'=> $request->id_kota,
				'nama_kota'=> $request->nama_kota,
				'provinsi' => 'Jawa Barat',
			);
			M_KotaKabupaten::where('id_kota','=',$request->id_kota)->update($data);
			\Session::flash('msg_edit_kota','Data KotaKabupaten Berhasil edit!');
			return Redirect::route('data_kota');
		}
}
?>