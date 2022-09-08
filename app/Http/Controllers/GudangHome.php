<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;


class GudangHome extends Controller
{
    public function index(){
   	$data['title'] = "Home";
   	$data['nama'] = Auth::User()->nama;
   	$data['id'] = Auth::User()->id;
   	return view('Backend/home_gudang',$data);
   }
   function logout(){
	        Auth::logout();
	        return \Redirect::to('/');
	}
}
?>