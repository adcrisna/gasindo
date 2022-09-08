<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\M_Kelurahan;
use App\Models\M_Customer;
use App\Models\M_KotaKabupaten;
use Redirect;
use App\Models\User;
use App\Models\M_Kecamatan;
use Auth;

class CalonCustomer extends Controller
{
    public function index()
		{
			$data['title'] = 'Data Calon Customer';
			$data['nama'] = Auth::User()->nama;
			$data['customer'] = M_Customer::where('users.status','=','Tidak Aktif')->join('kelurahan','kelurahan.id_kelurahan','=','customer.id_kelurahan')
			->join('users','users.id','=','customer.id')
			->join('kecamatan','kecamatan.id_kecamatan','=','kelurahan.id_kecamatan')
			->join('kota_kabupaten','kecamatan.id_kota','=','kota_kabupaten.id_kota')->get();
			$data['kota'] = M_KotaKabupaten::get();
			$data['kec'] = M_Kecamatan::get();
			return view('Backend/calon_customer',$data);
		}
	public function tampil_detail_calon(Request $request)
		{
			$data['title'] = 'Update Data Customer';
			$data['nama'] = Auth::User()->nama;
			$data['edit'] = M_Customer::where('customer.id_customer',$request->id_customer)
			->join('kelurahan','kelurahan.id_kelurahan','=','customer.id_kelurahan')
			->join('users','users.id','=','customer.id')
			->join('kecamatan','kecamatan.id_kecamatan','=','kelurahan.id_kecamatan')
			->join('kota_kabupaten','kecamatan.id_kota','=','kota_kabupaten.id_kota')->first();
			$data['kel'] =M_Kelurahan::get();
			$data['kota'] = M_KotaKabupaten::get();
			$data['kec'] = M_Kecamatan::get();
			
			return view('Backend/detail_calon',$data);
		}
		public function aktif_calon_customer(Request $request){
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
        \Session::flash('msg_aktif_cus',' Password & Data Customer Berhasil DiAktifkan!');
			return Redirect::route('data_calon');
		}else{

			$data = array(
			'id' => $request->id_login,
			'status' => $request->status,
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
        \Session::flash('msg_aktif_cus','Data Customer Berhasil Diaktifkan!');
			return Redirect::route('data_calon');
		}
	}
	public function hapus_calon_customer(Request $request){
		$data = M_Customer::where('id_customer','=',$request->id_cus);
		$query = $data->first();
		$data->delete();
		User::where('id','=',$query->id)->delete();
	    \Session::flash('msg_hapus_cus','Data Agen Berhasil Dihapus!');
		return Redirect::back();
	}
}
?>