<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;

class BagPengiriman extends Controller
{
     public function index(){
	   	$data['title'] = "Bagian Pengiriman";
	   	$data['nama'] = Auth::User()->nama;
	   	$data['id'] = Auth::User()->id;
	   	$data['penjualan'] = Auth::User()->where('level','=',2)->get();
	   	return view('Backend/data_bag_pengiriman',$data);
   }
   public function simpan_data_penjualan(Request $request){
   		$password = $request->password;
		$na = DB::table('users')->where('username','=',$request->username)->first();
		if(!$na){

			$u = DB::table('users')->insert([
	        'nama'     => $request->nama,
	        'username'   => $request->username,
	        'password'	=> bcrypt($password),
	        'no_tlpn'	=> $request->no_tlpn,
	        'level'		=>2,
	        'status'	=> "Aktif",
	        'created_at' => date('Y-m-d H:i:s'),
	        'updated_at' => date('Y-m-d H:i:s'),
	    ]);
        //redirect dengan pesan sukses
        \Session::flash('msg_simpan_penjualan','Data Petugas Bagian Pengiriman Berhasil Disimpan!');
			return \Redirect::back();
	    }else{
	        //redirect dengan pesan error
	        \Session::flash('msg_gagal','Username Sudah Ada!!');
				return \Redirect::back();
	    }
   }
   public function update_data_penjualan(Request $request){
		$password = $request->password;

		if (! empty($password)) {
			
		$data = array(	'id'     => $request->id,
	        			'nama'     => $request->nama,
				        'username'   => $request->username,
				        'password'	=> bcrypt($password),
				        'no_tlpn'	=> $request->no_tlpn,
				        'level'		=>2,
				        'status'	=>"Aktif",
				        'created_at' => $request->created_at,
				        'updated_at' => date('Y-m-d H:i:s'),
		 );
		DB::table('users')->where('id','=',$request->id)->update($data);
        \Session::flash('msg_edit_penjualan',' Password & Data Petugas Pengiriman Berhasil Diupdate!');
			return \Redirect::back();
		}else{
			$data = array(	'id'     => $request->id,
	        			'nama'     => $request->nama,
				        'username'   => $request->username,
				        'no_tlpn'	=> $request->no_tlpn,
				        'level'		=>2,
				        'status'	=>"Aktif",
				        'created_at' => $request->created_at,
				        'updated_at' => date('Y-m-d H:i:s'),
		 );
		DB::table('users')->where('id','=',$request->id)->update($data);
        \Session::flash('msg_edit_penjualan','Data Petugas Pengiriman Berhasil Diupdate!');
			return \Redirect::back();
		}
	}
	public function destroy(Request $request){
		$data = DB::table('users')->where('id','=',$request->id);
		$query = $data->first();
		$data->delete();
        \Session::flash('msg_hapus_penjualan','Data Petugas Bagian Pengiriman Berhasil Dihapus!');
			return \Redirect::back();
	}
}
?>