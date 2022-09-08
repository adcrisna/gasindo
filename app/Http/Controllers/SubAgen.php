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

class SubAgen extends Controller
{
    public function index()
		{
			$request = request();
			$data['nama'] = Auth::User()->nama;
			$data['id'] = Auth::User()->id;
			$data['title'] = 'Data Customer';
			$data['kel'] = M_Kelurahan::where('id_kelurahan',$request->id_kelurahan)
			->join('kecamatan','kelurahan.id_kecamatan','=','kecamatan.id_kecamatan')
			->join('kota_kabupaten','kecamatan.id_kota','=','kota_kabupaten.id_kota')->first();
			$data['customer'] = M_Customer::where('customer.id_kelurahan',$request->id_kelurahan)
			->join('kelurahan','kelurahan.id_kelurahan','=','customer.id_kelurahan')
			->join('users','users.id','=','customer.id')
			->join('kecamatan','kecamatan.id_kecamatan','=','kelurahan.id_kecamatan')
			->join('kota_kabupaten','kecamatan.id_kota','=','kota_kabupaten.id_kota')->get();
			return view('Backend/data_sub_agen',$data);
		}
		public function kecamatan(Request $request){
	        $kec = M_Kecamatan::where('id_kota','=',$request->id_kota)->pluck('nama_kecamatan', 'id_kecamatan');
	        return response()->json($kec);
    	}
	    public function kelurahan(Request $request){
	        $kel = M_Kelurahan::where('id_kecamatan','=',$request->id_kecamatan)->pluck('nama_kelurahan', 'id_kelurahan');
	        return response()->json($kel);
	    }
		public function tampil_data_edit_cust(Request $request)
		{
			$request = request();
			$data['title'] = 'Update Data Customer';
			$data['nama'] = Auth::User()->nama;
			$data['id'] = Auth::User()->id;	
			$data['edit'] = M_Customer::where('customer.id_customer',$request->id_customer)
			->join('kelurahan','kelurahan.id_kelurahan','=','customer.id_kelurahan')
			->join('users','users.id','=','customer.id')
			->join('kecamatan','kecamatan.id_kecamatan','=','kelurahan.id_kecamatan')
			->join('kota_kabupaten','kecamatan.id_kota','=','kota_kabupaten.id_kota')->first();
			$data['kel'] =M_Kelurahan::get();
			$data['kota'] = M_KotaKabupaten::get();
			$data['kec'] = M_Kecamatan::get();
			
			return view('Backend/data_edit_sub_agen',$data);
		}
		public function tampil_data_detail_cust(Request $request)
		{
			$request = request();
			$data['title'] = 'Detail Data Customer';
			$data['id'] = Auth::User()->id;
			$data['nama'] = Auth::User()->nama;
			$data['detail'] = M_Customer::where('customer.id_customer',$request->id_customer)
			->join('kelurahan','kelurahan.id_kelurahan','=','customer.id_kelurahan')
			->join('users','users.id','=','customer.id')
			->join('kecamatan','kecamatan.id_kecamatan','=','kelurahan.id_kecamatan')
			->join('kota_kabupaten','kecamatan.id_kota','=','kota_kabupaten.id_kota')->first();
			$data['kel'] =M_Kelurahan::join('kecamatan','kecamatan.id_kecamatan','=','kelurahan.id_kecamatan')
			->join('kota_kabupaten','kecamatan.id_kota','=','kota_kabupaten.id_kota')->get();
			
			return view('Backend/data_detail_sub_agen',$data);
		}
		public function simpan_cust(Request $request)
		{

			$na = DB::table('users')->where('username','=',$request->username)->first();
	        if (!$na) {
				$user = User::create([
					'nama'=> $request->nama_cus,
					'email' => $request->email,
					'username'=> $request->username,
					'password'=> bcrypt($request->password),
					'no_tlpn' => $request->no_tlpn,
					'alamat' => $request->alamat,
					'level' =>5,
					'status' => "Aktif",
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s')
				]);

				$data=array(
					'nama_customer'=> $request->nama_cus,
					'email_customer' => $request->email,
					'nik_customer'=> $request->nik,
					'no_hp'=> $request->no_tlpn,
					'id_kelurahan'=> $request->id_kel,
					'alamat' => $request->alamat,
					'latitude' => $request->lat,
					'longitude' => $request->lng,
					'id'=>$user->id,
				);
				M_Customer::insert($data);
				 \Session::flash('msg_simpan_agen','Data Customer Berhasil Disimpan!');
				return Redirect::back();
			}else{
	            \Session::flash('msg_gagal_daftar','Username sudah terdaftar!!');
	            return \Redirect::back();
        	}
		}
		public function edit_cust(Request $request){
			$password = $request->password;

		if (! empty($password)) {
	
		$data = array(
			'id' => $request->id_login,
			'password' => bcrypt($request->password),
			'updated_at' => date('Y-m-d H:i:s'),
		);

		DB::table('users')->where('id','=',$request->id_login)->update($data);

		$data = array(	
				'id_customer' => $request->id_cus,
	        	'nama_customer'=> $request->nama_cus,
				'email_customer' => $request->email,
				'nik_customer'=> $request->nik,
				'no_hp'=> $request->no_tlpn,
				'latitude' => $request->latitude,
				'longitude' => $request->longitude,
				'id_kelurahan'=> $request->kelurahan,
				'alamat' => $request->alamat,
				'id'=>$request->id_login,
		 );
		M_Customer::where('id_customer','=',$request->id_cus)->update($data);
        \Session::flash('msg_edit_agen',' Password & Data Customer Berhasil Diupdate!');
			return Redirect::route('data_cust',$request->kelurahan);
		}else{

			$data = array(
			'id' => $request->id_login,
			'status' => $request->status,
			'updated_at' => date('Y-m-d H:i:s'),
		);

		DB::table('users')->where('id','=',$request->id_login)->update($data);

			$data = array(
				'id_customer' => $request->id_cus,
	        	'nama_customer'=> $request->nama_cus,
				'email_customer' => $request->email,
				'nik_customer'=> $request->nik,
				'no_hp'=> $request->no_tlpn,
				'latitude' => $request->latitude,
				'longitude' => $request->longitude,
				'id_kelurahan'=> $request->kelurahan,
				'alamat' => $request->alamat,
				'id'=>$request->id_login,
		 );
		M_Customer::where('id_customer','=',$request->id_cus)->update($data);
        \Session::flash('msg_edit_agen','Data Customer Berhasil DiUpdate!');
			return Redirect::route('data_cust',$request->kelurahan);
		}
	}
	public function hapus_cust(Request $request){
		$data = M_Customer::where('id_customer','=',$request->id_customer);
		$query = $data->first();
		$data->delete();
		User::where('id','=',$query->id)->delete();
	    \Session::flash('msg_hapus_agen','Data Customer Berhasil Dihapus!');
		return Redirect::back();
	}
}
?>