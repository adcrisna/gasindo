<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\M_Informasi;
use App\Models\M_Pemesanan;
use App\Models\M_Customer;
use Illuminate\Support\Facades\DB;

class AdminHome extends Controller
{
   public function index(){
   	$data['title'] = "Home";
   	$data['id'] = Auth::User()->id;
   	$data['nama'] = Auth::User()->nama;
   	$cek = M_Pemesanan::where('status_pemesanan','Diproses')->get();
   	$data['pemesanan'] = count($cek);
   	$cus = M_Customer::get();
   	$data['customer'] = count($cus);
   	return view('Backend/home_admin',$data);
   }
   public function setting(Request $request){
   	$data['title'] = "Setting";
   	$data['nama'] = Auth::User()->nama;
   	$data['id'] = Auth::User()->id;
   	$data['admin'] = Auth::User()->where('id','=',$request->id)->first();
   	return view('Backend/setting_admin',$data);
   }
   public function setting_aksi(Request $request){
   	$password = $request->password;

		if (! empty($password)) {
			
		$data = array(	'id'     => $request->id,
	        			'nama'     => $request->nama,
				        'username'   => $request->username,
				        'password'	=> bcrypt($password),
				        'no_tlpn'	=> $request->no_tlpn,
				        'level'		=>1,
				        'status'	=>"Aktif",
				        'created_at' => $request->created_at,
				        'updated_at' => date('Y-m-d H:i:s'),
		 );
		DB::table('users')->where('id','=',$request->id)->update($data);
        \Session::flash('msg_update_profile','Berhasil Melakukan Update!');
			return \Redirect::back();
		} else{
			$data = array(	'id'     => $request->id,
	        			'nama'     => $request->nama,
				        'username'   => $request->username,
				        'no_tlpn'	=> $request->no_tlpn,
				        'level'		=>1,
				        'status'	=>"Aktif",
				        'created_at' => $request->created_at,
				        'updated_at' => date('Y-m-d H:i:s'),
		 );
		DB::table('users')->where('id','=',$request->id)->update($data);
        \Session::flash('msg_update_profile','Berhasil Melakukan Update!');
			return \Redirect::back();
		}
   }
   public function informasi(Request $request){
	   	$data['title'] = "Informasi";
	   	$data['nama'] = Auth::User()->nama;
	   	$data['id'] = Auth::User()->id;
	   	$data['informasi'] = M_Informasi::where('informasi.id',$request->id)
	   	->join('users','users.id','=','informasi.id')->first();
	   	return view('Backend/informasi',$data);
   }
   public function informasi_aksi(Request $request){

   		$data = array(	'id_informasi'     => $request->id_informasi,
	        			'judul_informasi'     => $request->judul_informasi,
	        			'informasi'     => $request->informasi,
				        'ongkir'   => $request->ongkir,
				        'no_rekening'	=> $request->no_rek,
				        'id'		=>$request->id,
				 
		 );
		M_Informasi::where('id_informasi','=',$request->id_informasi)->update($data);
        \Session::flash('msg_update_informasi','Berhasil Melakukan Update!');
			return \Redirect::back();
   }
   function logout(){
	        Auth::logout();
	        return \Redirect::to('/');
	}
}
?>