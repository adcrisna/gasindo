<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Models\M_KotaKabupaten;
use App\Models\M_Kecamatan;
use Redirect;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Kecamatan extends Controller
{
    public function index()
		{
			$request = request();
			$data['kota'] = M_KotaKabupaten::where('id_kota',$request->id_kota)->first();
			$data['title'] = 'Data Kacamatan';
			$data['id'] = Auth::User()->id;
			$data['nama'] = Auth::User()->nama;
			$data['kec'] = M_Kecamatan::where('kecamatan.id_kota',$request->id_kota)
			->join('kota_kabupaten','kota_kabupaten.id_kota','=','kecamatan.id_kota')->get();
			return view('Backend/data_kecamatan',$data);
		}
	public function simpan_kecamatan(Request $request)
		{
			$data=array(
				'nama_kecamatan'=>$request->nama_kec,
				'jarak'=>$request->jarak,
				'id_kota'=>$request->id_kota,
			);
			M_Kecamatan::insert($data);
			\Session::flash('msg_simpan_kec','Data Kecamatan Berhasil Ditambah!');
			return Redirect::route('data_kec',$data['id_kota']);
		}
		public function hapus_kecamatan(Request $request)
		{
			$data = M_Kecamatan::where('id_kecamatan','=',$request->id_kecamatan);
			$query = $data->first();
			$data->delete();
	        \Session::flash('msg_hapus_kec','Data Kecamatan Berhasil Dihapus!');
				return \Redirect::back();
		}
		public function edit_kecamatan(Request $request)
		{
			$data=array(
				'id_kecamatan'=>$request->id_kec,
				'nama_kecamatan'=>$request->nama_kec,
				'jarak'=>$request->jarak,

			);
			M_Kecamatan::where('id_kecamatan','=',$request->id_kec)->update($data);
			\Session::flash('msg_edit_kec','Data kecamatan Berhasil Diupdate!');
			return Redirect::back();
		}
}
?>