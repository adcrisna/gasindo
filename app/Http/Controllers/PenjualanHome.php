<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\M_Pemesanan;

class PenjualanHome extends Controller
{
    public function index()
    {
     	$data['title'] = "Home";
     	$data['nama'] = Auth::User()->nama;
     	$data['id'] = Auth::User()->id;
        $cek = M_Pemesanan::where('pemesanan.status_pemesanan','Pengiriman')->get();
        $data['pengiriman'] = count($cek);
     	return view('Backend/home_penjualan',$data);
    }  
   function logout(){
    	Auth::logout();
    	return \Redirect::to('/');
    }
}
?>