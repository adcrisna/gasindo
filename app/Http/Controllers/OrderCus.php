<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\M_Gas;


class OrderCus extends Controller
{
   public function index(){
   	$data['title'] = "Order";
   	$data['gas'] = M_Gas::get();
   	return view('FrontEnd/order_cus',$data);
   }
}
?>