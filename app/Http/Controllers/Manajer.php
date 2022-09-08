<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class Manajer extends Controller
{
     public function index(){
	   	$data['title'] = "Data Manajer";
	   	$data['nama'] = Auth::User()->nama;
	   	$data['id'] = Auth::User()->id;
	   	$data['manajer'] = Auth::User()->where('level','=',4)->get();
	   	return view('Backend/data_manajer',$data);
   }
   public function simpan_data_manajer(Request $request){
   		$password = $request->password;
		$na = DB::table('users')->where('username','=',$request->username)->first();
		if(!$na){

			$u = DB::table('users')->insert([
	        'nama'     => $request->nama,
	        'username'   => $request->username,
	        'password'	=> bcrypt($password),
	        'no_tlpn'	=> $request->no_tlpn,
	        'alamat'	=> $request->alamat,
	        'level'		=>4,
	        'status'	=> "Aktif",
	        'created_at' => date('Y-m-d h:i:s'),
	        'updated_at' => date('Y-m-d h:i:s')
	    ]);
        //redirect dengan pesan sukses
        \Session::flash('msg_simpan_manajer','Data Manajer Berhasil Disimpan!');
			return \Redirect::back();
	    }else{
	        //redirect dengan pesan error
	        \Session::flash('msg_gagal','Username Sudah Ada!!');
				return \Redirect::back();
	    }
   }
   public function update_data_manajer(Request $request){
		$password = $request->password;

		if (! empty($password)) {
			
		$data = array(	'id'     => $request->id,
	        			'nama'     => $request->nama,
				        'username'   => $request->username,
				        'password'	=> bcrypt($password),
				        'no_tlpn'	=> $request->no_tlpn,
				        'alamat'	=> $request->alamat,
				        'level'		=>4,
				        'status'	=>"Aktif",
				        'created_at' => $request->created_at,
				        'updated_at' => date('Y-m-d h:i:s')
		 );
		DB::table('users')->where('id','=',$request->id)->update($data);
        \Session::flash('msg_edit_manajer',' Password & Data Manajer Berhasil DiUpdate!');
			return \Redirect::back();
		}else{
			$data = array(	'id'     => $request->id,
	        			'nama'     => $request->nama,
				        'username'   => $request->username,
				        'no_tlpn'	=> $request->no_tlpn,
				        'alamat'	=> $request->alamat,
				        'level'		=>4,
				        'status'	=>"Aktif",
				        'created_at' => $request->created_at,
				        'updated_at' => date('Y-m-d h:i:s')
		 );
		DB::table('users')->where('id','=',$request->id)->update($data);
        \Session::flash('msg_edit_penjualan','Data Manajer Berhasil DiUpdate!');
			return \Redirect::back();
		}
	}
	public function destroy(Request $request){
		$data = DB::table('users')->where('id','=',$request->id);
		$query = $data->first();
		$data->delete();
        \Session::flash('msg_hapus_manajer','Data Manajer Berhasil DiHapus!');
			return \Redirect::back();
	}
}
?>