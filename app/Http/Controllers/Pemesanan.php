<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Models\M_Gas;
use App\Models\M_Customer;
use App\Models\User;
use App\Models\M_Kelurahan;
use App\Models\M_KotaKabupaten;
use Redirect;
use App\Models\M_Kecamatan;
use App\Models\M_DetailPemesanan;
use App\Models\M_Pemesanan;
use App\Models\M_HistoriGas;
use App\Models\M_Informasi;
use Fpdf;

class Pemesanan extends Controller
{
    public function data_pesanan(Request $request){
        $data['title'] = "Data Pemesanan";
        $data['id'] = Auth::User()->id;
        $data['nama'] = Auth::User()->nama;
        $data['pesanan'] = M_Pemesanan::where('pemesanan.status_pemesanan','Diproses')->orWhere('pemesanan.status_pemesanan','Konfirmasi Selesai')->get();
        return view('Backend/data_pemesanan',$data);
    }
    public function detail_data_pemesanan(Request $request){
        $data['title'] = "Detail Data Pemesanan";
        $data['nama'] = Auth::User()->nama;
        $data['id'] = Auth::User()->id;
        $data['informasi'] = M_Informasi::where('informasi.id',1)->first();
        $info = M_Informasi::where('informasi.id',1)->first();
        $kota = M_Pemesanan::where('id_pemesanan',$request->id_pemesanan)
        ->join('users','users.id','=','pemesanan.id')
        ->join('customer','customer.id','=','users.id')
        ->join('kelurahan','kelurahan.id_kelurahan','=','customer.id_kelurahan')
        ->join('kecamatan','kecamatan.id_kecamatan','=','kelurahan.id_kecamatan')
        ->join('kota_kabupaten','kota_kabupaten.id_kota','=','kecamatan.id_kota')->first();
        $dtl = M_DetailPemesanan::where('detail_pemesanan.no_invoice',$request->no_invoice)
        ->join('gas','gas.id_gas','=','detail_pemesanan.id_gas')->get();
        $data['pesanan'] = M_Pemesanan::where('id_pemesanan',$request->id_pemesanan)
        ->join('users','users.id','=','pemesanan.id')
        ->join('customer','customer.id','=','users.id')
        ->join('kelurahan','kelurahan.id_kelurahan','=','customer.id_kelurahan')
        ->join('kecamatan','kecamatan.id_kecamatan','=','kelurahan.id_kecamatan')
        ->join('kota_kabupaten','kota_kabupaten.id_kota','=','kecamatan.id_kota')->first();
        $data['detail'] = M_Pemesanan::where('pemesanan.id_pemesanan',$request->id_pemesanan)
        ->join('detail_pemesanan','detail_pemesanan.no_invoice','=','pemesanan.no_invoice')
        ->join('gas','gas.id_gas','=','detail_pemesanan.id_gas')->get();
        return view('Backend/detail_data_pemesanan',$data);
    }
    public function kirim_produk(Request $request){

    	$data=array(
				'status_pemesanan'=> "Pengiriman",
			);

		M_Pemesanan::where('id_pemesanan','=',$request->id_pemesanan)->update($data);
		\Session::flash('msg_kirim_gas','Data Pemesanan Sudah Dalam Pengiriman!');
		return Redirect::route('data_pemesanan');
    }
    public function tolak_pemesanan(Request $request){
            $psn = $request->id_detail;
            $new_stok = 0;

            for ($i=0; $i <count($psn) ; $i++) { 
                
                $data_pesan = M_DetailPemesanan::where('id_detail_pemesanan',$request->id_detail[$i])
                ->join('gas','gas.id_gas','=','detail_pemesanan.id_gas')->get();
            

                foreach ($data_pesan as $key => $value) {
                    $new_stok = $value->stok + $value->jumlah_beli;

                    $data=array(
                    'stok'=>$new_stok,
                );
                M_Gas::where('id_gas','=',$value->id_gas)->update($data);

                    $data=array(
                    'id_gas' => $value->id_gas,
                    'jumlah_gas'=>$value->jumlah_beli,
                    'status_gas' => 'Masuk',
                    'keterangan_gas' => "Produk Refund",
                    'tgl_gas' => date('Y-m-d H:i:s'),
                    'bukti_pembelian' => $request->no_invoice,
                );
                M_HistoriGas::insert($data);

                $dt = M_DetailPemesanan::where('id_detail_pemesanan','=',$value->id_detail_pemesanan);
                $query = $dt->get();
                $dt->delete();
                }
        }
                $pmsn = M_Pemesanan::where('id_pemesanan','=',$request->id_pemesanan);
                $query = $pmsn->first();
                $pmsn->delete();
            \Session::flash('msg_batal_pesanan','Pemesanan Telah Dibatalkan !');
            return Redirect::route('data_pemesanan');
    }
    public function data_penjualan(Request $request){
        $data['title'] = "Laporan Penjualan";
        $data['id'] = Auth::User()->id;
        $data['nama'] = Auth::User()->nama;
        $data['pesanan'] = M_Pemesanan::where('pemesanan.status_pemesanan','Selesai')->get();
        return view('Backend/data_penjualan',$data);
    }
     public function detail_penjualan(Request $request){
        $data['title'] = "Detail Data Penjualan";
        $data['nama'] = Auth::User()->nama;
        $data['id'] = Auth::User()->id;
        $data['informasi'] = M_Informasi::where('informasi.id',1)->first();
        $info = M_Informasi::where('informasi.id',1)->first();
         $kota = M_Pemesanan::where('id_pemesanan',$request->id_pemesanan)
        ->join('users','users.id','=','pemesanan.id')
        ->join('customer','customer.id','=','users.id')
        ->join('kelurahan','kelurahan.id_kelurahan','=','customer.id_kelurahan')
        ->join('kecamatan','kecamatan.id_kecamatan','=','kelurahan.id_kecamatan')
        ->join('kota_kabupaten','kota_kabupaten.id_kota','=','kecamatan.id_kota')->first();
        $dtl = M_DetailPemesanan::where('detail_pemesanan.no_invoice',$request->no_invoice)
        ->join('gas','gas.id_gas','=','detail_pemesanan.id_gas')->get();
        $data['pesanan'] = M_Pemesanan::where('id_pemesanan',$request->id_pemesanan)
        ->join('users','users.id','=','pemesanan.id')
        ->join('customer','customer.id','=','users.id')
        ->join('kelurahan','kelurahan.id_kelurahan','=','customer.id_kelurahan')
        ->join('kecamatan','kecamatan.id_kecamatan','=','kelurahan.id_kecamatan')
        ->join('kota_kabupaten','kota_kabupaten.id_kota','=','kecamatan.id_kota')->first();
        $data['detail'] = M_Pemesanan::where('pemesanan.id_pemesanan',$request->id_pemesanan)
        ->join('detail_pemesanan','detail_pemesanan.no_invoice','=','pemesanan.no_invoice')
        ->join('gas','gas.id_gas','=','detail_pemesanan.id_gas')->get();
        return view('Backend/detail_data_penjualan',$data);
    }
    public function laporan_penjualan(Request $request){
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
            $pdf::cell(30,6,'Tanggal',1,0,'C');
            $pdf::cell(40,6,'No Invoice',1,0,'C');
            $pdf::cell(42,6,'NIK Customer',1,0,'C');
            $pdf::cell(45,6,'Total Pembayaran',1,0,'C');
            $pdf::cell(33,6,'Metode',1,0,'C');
            $pdf::SetFont('Helvetica','','11');
            $pdf::ln();

            $tgl_dari = $request->tgl_dari;
            $tgl_sampai = $request->tgl_sampai;
            $dari = date('Y-m-d',strtotime($tgl_dari));
            $sampai = date('Y-m-d',strtotime($tgl_sampai));

            $pemesanan = M_Pemesanan::where('status_pemesanan','Selesai')->whereBetween('tgl_pemesanan',[$dari,$sampai])
            ->join('users','users.id','=','pemesanan.id')->join('customer','customer.id','=','users.id')->get();

            foreach ($pemesanan as $key => $value) {
                $pdf::cell(30,6,$value->tgl_pemesanan,1,0,'C');
                $pdf::cell(40,6,$value->no_invoice,1,0,'C');
                $pdf::cell(42,6,$value->nik_customer,1,0,'C');
                $pdf::cell(45,6,'Rp. '.number_format($value->total_bayar,0,',','.'),1,0,'C');
                $pdf::cell(33,6,$value->metode_pembayaran,1,0,'C');
                $pdf::ln();

                $dtl[] = $value->id_pemesanan;

                
                for ($i=0; $i <count($dtl) ; $i++) {

                    $detail = M_Pemesanan::where('id_pemesanan',$dtl[$i])->join('detail_pemesanan','detail_pemesanan.no_invoice','=','pemesanan.no_invoice')->join('gas','gas.id_gas','=','detail_pemesanan.id_gas')->get();
                }
                    foreach ($detail as $key => $d) {
                        $pdf::cell(30,6,'',0,0,'C');
                        $pdf::cell(40,6,'',0,0,'C');
                        $pdf::cell(42,6,$d->nama_gas,1,0,'C');
                        $pdf::cell(45,6,'Rp. '.number_format($d->sub_total,0,',','.'),1,0,'C');
                        $pdf::cell(33,6,$d->jumlah_beli,1,0,'C');
                        $pdf::ln();
                }
            }
            foreach ($pemesanan as $key => $value) {
                $pendapatan[] = $value->total_bayar;
            }
            $pdf::SetFont('Helvetica','B','11');
            $pdf::ln();
            $pdf::cell(30,6,'',0,0,'C');
            $pdf::cell(40,6,'',0,0,'C');
            $pdf::cell(42,6,'',0,0,'C');
            $pdf::cell(45,6,'Total Pendapatan :',0,0,'C');
            $pdf::cell(33,6,'Rp. '.number_format(array_sum($pendapatan),0,',','.'),0,0,'C');
            $pdf::ln();
            $pdf::Output(0);
            exit;
        }
}
?>