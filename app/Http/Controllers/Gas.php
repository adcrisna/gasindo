<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Redirect;
use App\Models\User;
use App\Models\M_Gas;
use Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\M_HistoriGas;
use Fpdf;
use Illuminate\Support\Facades\DB;

class Gas extends Controller
{
    public function index()
		{
			$data['title'] = 'Data Produk';
			$data['nama'] = Auth::User()->nama;
			$data['id'] = Auth::User()->id;
			$data['gas'] = M_Gas::get();
			return view('Backend/data_gas',$data);
		}
	public function simpan_data_gas(Request $request)
	{
		$photo = $request->file('foto_gas')->getClientOriginalName();
		$destination = base_path() .'/public/uploads';
		$request->file('foto_gas')->move($destination,$photo);


			$gas=array(
				'id_gas' => $request->id_gas,
				'nama_gas'=>$request->nama,
				'berat'=>$request->berat,
				'foto_gas'=>$photo,
				'harga_refill'=>$request->harga_refill,
				'harga'=>$request->harga,
				'stok'=>$request->stok,
			);
			M_Gas::insert($gas);

			$bukti = $request->file('bukti')->getClientOriginalName();
			$destinati = base_path() .'/public/uploads';
			$request->file('bukti')->move($destinati,$bukti);
			$data=array(
				'id_gas' => $request->id_gas,
				'jumlah_gas'=>$request->stok,
				'status_gas' => 'Masuk',
				'keterangan_gas' => 'Penambahan Produk Baru',
				'tgl_gas' => date('Y-m-d H:i:s'),
				'bukti_pembelian' =>$bukti,
			);
			M_HistoriGas::insert($data);
			\Session::flash('msg_simpan_gas','Data GAS Berhasil Ditambah!');
			return Redirect::route('data_gas');
	}
	public function tampil_edit_data_gas(Request $request)
	{
		$data['title'] = 'Update Data GAS';
		$data['nama'] = Auth::User()->nama;
		$data['id'] = Auth::User()->id;
		$data['edit'] = M_Gas::where('gas.id_gas',$request->id_gas)->first();
			
		return view('Backend/data_edit_gas',$data);
	}
	public function edit_data_gas(Request $request){

		$p = $request->foto_gas;

		if (empty($p)) {
			$data=array(
				'nama_gas'=>$request->nama,
				'berat'=>$request->berat,
				'harga_refill'=>$request->harga_refill,
				'harga'=>$request->harga,
				'stok'=>$request->stok,
			);
			M_Gas::where('id_gas','=',$request->id_gas)->update($data);
			\Session::flash('msg_edit_gas','Data GAS Berhasil Diedit!');
			return Redirect::route('data_gas');
		}else {	
			$data=array(
				'nama_gas'=>$request->nama,
				'berat'=>$request->berat,
				'harga_refill'=>$request->harga_refill,
				'harga'=>$request->harga,
				'stok'=>$request->stok,
			);

		if ($request->file('foto_gas'))
			{
		        if(\File::exists(public_path('uploads/'.$request->foto))){
				    \File::delete(public_path('uploads/'.$request->foto));
				  }else{
				    dd('File does not exists.');
				  }

				$photo = $request->file('foto_gas')->getClientOriginalName();
				$destination = base_path() .'/public/uploads';
				$request->file('foto_gas')->move($destination,$photo);
				$data['foto_gas'] = $photo;
			}
			M_Gas::where('id_gas','=',$request->id_gas)->update($data);
			\Session::flash('msg_edit_gas','Data GAS Berhasil Diedit!');
			return Redirect::route('data_gas');
		}
	}
	public function hapus_data_gas(Request $request)
		{
			$data = M_Gas::where('id_gas','=',$request->id_gas);
			$query = $data->first();
			if(\File::exists(public_path('uploads/'.$query->foto_gas))){
				\File::delete(public_path('uploads/'.$query->foto_gas));
			}else{
				dd('File does not exists.');
			}
			$data->delete();
	        \Session::flash('msg_hapus_gas','Data Gas Berhasil Dihapus!');
			return \Redirect::back();
		}
		public function tambah_stok_gas(Request $request)
		{
			$bukti = $request->file('bukti_p')->getClientOriginalName();
			$destination = base_path() .'/public/uploads';
			$request->file('bukti_p')->move($destination,$bukti);

			$gas = M_Gas::where('id_gas','=',$request->t_id_g)->first();
			$stok_lama = $gas->stok;
			$jmlh = $request->t_stok;
			$stok_baru = $stok_lama + $jmlh;

			$data=array(
				'id_gas' => $request->t_id_g,
				'jumlah_gas'=>$jmlh,
				'status_gas' => 'Masuk',
				'keterangan_gas' => "Penambahan Stok Produk",
				'tgl_gas' => date('Y-m-d H:i:s'),
				'bukti_pembelian' =>$bukti,
			);
			M_HistoriGas::insert($data);

			$data=array(
				'stok'=>$stok_baru,
			);
			M_Gas::where('id_gas','=',$request->t_id_g)->update($data);
			\Session::flash('msg_tambah_stok','Stok GAS Berhasil Ditambah!');
			return \Redirect::back();
		}
		public function kurang_stok_gas(Request $request)
		{
			$bukti = $request->file('bukti')->getClientOriginalName();
			$destination = base_path() .'/public/uploads';
			$request->file('bukti')->move($destination,$bukti);

			$gas = M_Gas::where('id_gas','=',$request->k_id_g)->first();
			$stok_lama = $gas->stok;
			$jmlh = $request->k_stok;
			$stok_baru = $stok_lama - $jmlh;

			$data=array(
				'id_gas' => $request->k_id_g,
				'jumlah_gas'=>$jmlh,
				'status_gas' => 'Keluar',
				'keterangan_gas' => "Pengurangan Stok Produk",
				'tgl_gas' => date('Y-m-d H:i:s'),
				'bukti_pembelian' =>$bukti,
			);
			M_HistoriGas::insert($data);

			$data=array(
				'stok'=>$stok_baru,
			);
			M_Gas::where('id_gas','=',$request->k_id_g)->update($data);
			\Session::flash('msg_kurang_stok','Stok GAS Berhasil DiKurangi!');
			return \Redirect::back();
		}
		public function data_histori()
		{
			$data['title'] = 'Histori Produk';
			$data['nama'] = Auth::User()->nama;
			$data['id'] = Auth::User()->id;
			$data['histori'] = M_HistoriGas::get();
			return view('Backend/histori_gas',$data);
		}
		public function laporan_produk(Request $request){
			$pdf = new fPdf('P','mm');
			$pdf::SetTitle("Laporan Produk");
			$pdf::addPage('P','A4');
			$pdf::setX(40);
			$pdf::SetFont('Helvetica','B','13');
			$pdf::cell(130,6,"Laporan Data Produk",0,2,'C');
			$pdf::SetFont('Helvetica','B','13');
			$pdf::cell(130,6,"PT. GASINDO CIREBON PRIMA",0,2,'C');
			$pdf::SetFont('Helvetica','','10');
			$pdf::cell(130,6,"Jl. Tuparev No. 54 Kota Cirebon",0,2,'C');
			$pdf::SetFont('Helvetica','B','12');
			$pdf::cell(130,6,"",0,2,'C');
			$pdf::line(10,($pdf::getY()+3),200,($pdf::getY()+3));
			$pdf::ln();
			$pdf::SetFont('Helvetica','','11');
			$pdf::ln();
			$pdf::cell(65,6,'',0,0,'');
			$pdf::cell(40,6,'',0,0,'');
			$pdf::cell(40,6,'',0,0,'');
			$pdf::cell(45,6,"Cirebon, ".date('d-M-Y'),0,0,'');
			$pdf::ln();
			$pdf::ln();
			$pdf::SetFont('Helvetica','B','11');
			$pdf::cell(65,6,'Nama Produk',1,0,'C');
			$pdf::cell(40,6,'Status',1,0,'C');
			$pdf::cell(40,6,'Jumlah',1,0,'C');
			$pdf::cell(45,6,'Tanggal',1,0,'C');
			$pdf::SetFont('Helvetica','','11');
			$pdf::ln();

			$tgl_dari = $request->tgl_dari;
			$tgl_sampai = $request->tgl_sampai;
			$dari = date('Y-m-d',strtotime($tgl_dari));
			$sampai = date('Y-m-d',strtotime($tgl_sampai));

			$histori = M_HistoriGas::join('gas','gas.id_gas','=','histori_gas.id_gas')->whereBetween('tgl_gas',[$dari,$sampai])->get();
			$gas = M_Gas::get();
			$nm = Auth::User()->nama;
			$masuk = M_HistoriGas::selectRaw("histori_gas.id_gas, gas.nama_gas, sum(histori_gas.jumlah_gas) as jumlh, histori_gas.status_gas")->join('gas','gas.id_gas','=','histori_gas.id_gas')->where('status_gas','Masuk')->whereBetween('tgl_gas',[$dari,$sampai])->groupBy('gas.nama_gas')->get();
			$terjual = M_HistoriGas::selectRaw("histori_gas.id_gas, gas.nama_gas, sum(histori_gas.jumlah_gas) as jumlh, histori_gas.status_gas")->join('gas','gas.id_gas','=','histori_gas.id_gas')->where('status_gas','Terjual')->whereBetween('tgl_gas',[$dari,$sampai])->groupBy('gas.nama_gas')->get();
			$keluar = M_HistoriGas::selectRaw("histori_gas.id_gas, gas.nama_gas, sum(histori_gas.jumlah_gas) as jumlh, histori_gas.status_gas")->join('gas','gas.id_gas','=','histori_gas.id_gas')->where('status_gas','Keluar')->whereBetween('tgl_gas',[$dari,$sampai])->groupBy('gas.nama_gas')->get();

			foreach ($histori as $key => $value) {
				$pdf::cell(65,6,$value->nama_gas,1,0,'C');
				$pdf::cell(40,6,$value->status_gas,1,0,'C');
				$pdf::cell(40,6,$value->jumlah_gas,1,0,'C');
				$pdf::cell(45,6,$value->tgl_gas,1,0,'C');
				$pdf::ln();
			}
			$pdf::SetFont('Helvetica','B','11');
			$pdf::ln();
			$pdf::cell(65,6,"Total Produk Masuk :",0,0,'');
			$pdf::cell(40,6,'',0,0,'');
			$pdf::cell(40,6,'',0,0,'');
			$pdf::cell(45,6,'',0,0,'');
			$pdf::ln();
			$pdf::SetFont('Helvetica','','11');
			$pdf::ln();
			foreach ($masuk as $key => $value) {
				$pdf::cell(65,6,$value->nama_gas,0,0,'');
				$pdf::cell(40,6,$value->jumlh,0,0,'');
				$pdf::cell(40,6,'',0,0,'');
				$pdf::cell(45,6,'',0,0,'');
				$pdf::ln();
			}
			$pdf::SetFont('Helvetica','B','11');
			$pdf::ln();
			$pdf::cell(65,6,"Total Produk Terjual :",0,0,'');
			$pdf::cell(40,6,'',0,0,'');
			$pdf::cell(40,6,'',0,0,'');
			$pdf::cell(45,6,'',0,0,'');
			$pdf::ln();
			$pdf::SetFont('Helvetica','','11');
			$pdf::ln();
			foreach ($terjual as $key => $value) {
				$pdf::cell(65,6,$value->nama_gas,0,0,'');
				$pdf::cell(40,6,$value->jumlh,0,0,'');
				$pdf::cell(40,6,'',0,0,'');
				$pdf::cell(45,6,'',0,0,'');
				$pdf::ln();
			}
			$pdf::SetFont('Helvetica','B','11');
			$pdf::ln();
			$pdf::cell(65,6,"Total Produk Keluar :",0,0,'');
			$pdf::cell(40,6,'',0,0,'');
			$pdf::cell(40,6,'',0,0,'');
			$pdf::cell(45,6,'',0,0,'');
			$pdf::ln();
			$pdf::SetFont('Helvetica','','11');
			$pdf::ln();
			foreach ($keluar as $key => $value) {
				$pdf::cell(65,6,$value->nama_gas,0,0,'');
				$pdf::cell(40,6,$value->jumlh,0,0,'');
				$pdf::cell(40,6,'',0,0,'');
				$pdf::cell(45,6,'',0,0,'');
				$pdf::ln();
			}
			$pdf::SetFont('Helvetica','B','11');
			$pdf::ln();
			$pdf::cell(65,6,"Stok Produk Saat ini :",0,0,'');
			$pdf::cell(40,6,'',0,0,'');
			$pdf::cell(40,6,'',0,0,'');
			$pdf::cell(45,6,'',0,0,'');
			$pdf::ln();
			$pdf::SetFont('Helvetica','','11');
			$pdf::ln();
			foreach ($gas as $key => $value) {
				$pdf::cell(65,6,$value->nama_gas,0,0,'');
				$pdf::cell(40,6,$value->stok,0,0,'');
				$pdf::cell(40,6,'',0,0,'');
				$pdf::cell(45,6,'',0,0,'');
				$pdf::ln();
			}
			$pdf::Output(0);
			exit;
		}
}
?>