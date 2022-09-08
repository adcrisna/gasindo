<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\M_Gas;
use App\Models\M_KotaKabupaten;
use App\Models\M_Kecamatan;
use App\Models\M_Kelurahan;
use App\Models\User;
use App\Models\M_Customer;
use Illuminate\Support\Facades\DB;
use App\Models\M_Informasi;

class Login extends Controller
{

    public function index(){
        $data['gas'] = M_Gas::get();
        $data['informasi'] = M_Informasi::where('informasi.id',1)->first();
    	return view('index',$data);
    }

    public function produk()
    {
        $data['title'] = "Produk";
        $data['gas'] = M_Gas::get();
        return view('produk',$data);
    }
    public function form_register()
    {
        $data['kota'] = M_KotaKabupaten::get();
        return view('register',$data);
    }
    public function kecamatan(Request $request){
        $kec = M_Kecamatan::where('id_kota','=',$request->id_kota)->pluck('nama_kecamatan', 'id_kecamatan');
        return response()->json($kec);
    }
    public function kelurahan(Request $request){
        $kel = M_Kelurahan::where('id_kecamatan','=',$request->id_kecamatan)->pluck('nama_kelurahan', 'id_kelurahan');
        return response()->json($kel);
    }
    public function proses_daftar(Request $request){

        $na = DB::table('users')->where('username','=',$request->username)->first();
        if (!$na) {
        $user = User::create([
                'nama'=> $request->nama_cus,
                'email' => $request->email,
                'username'=> $request->username,
                'password'=> bcrypt($request->password),
                'no_tlpn' => $request->no_tlpn,
                'alamat' => $request->alamat,
                'level'=>5,
                'status' => "Aktif",
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            $data=array(
                'nama_customer'=> $request->nama_cus,
                'email_customer' => $request->email,
                'nik_customer'=> $request->nik,
                'no_hp'=> $request->no_tlpn,
                'id_kelurahan'=> $request->kelurahan,
                'alamat' => $request->alamat,
                'latitude' => $request->lat,
                'longitude' => $request->lng,
                'id'=>$user->id,
            );
            M_Customer::insert($data);
             \Session::flash('msg_daftar_cus','Registrasi berhasil!! Silahkan tunggu 1x24 jam akan ada pemberitahuan melalui WhatsApp/Email anda');
            return \Redirect::route('index');
        }else{
            \Session::flash('msg_gagal_daftar','Username sudah terdaftar!!');
            return \Redirect::route('register');
        }
    }
    public function form_login(){
        return view('login');
    }
    public function proseslogin(Request $request){
    	if (Auth::attempt(['username'=>$request->username,'password'=>$request->password]))
        {
            if ((Auth::user()->level == "1")&&(Auth::user()->status == "Aktif")) 
            {
                return \Redirect()->to('/admin/home');
            }
            else if ((Auth::user()->level == "2")&&(Auth::user()->status == "Aktif"))
            {
                 return \Redirect()->to('/pengiriman/home');
            }
            else if ((Auth::user()->level == "3")&&(Auth::user()->status == "Aktif"))
            {
                return \Redirect()->to('/gudang/home');
            }
             else if ((Auth::user()->level == "5")&&(Auth::user()->status == "Aktif"))
            {
                return \Redirect()->to('/customer/home');
            }else{
                \Session::flash('msg_login','Akun Belum Aktif!');
            return \Redirect::back();
            }
        }
        else
        {
            \Session::flash('msg_login','Username Atau Password Salah!');
            return \Redirect::back();
        }
    }
}
