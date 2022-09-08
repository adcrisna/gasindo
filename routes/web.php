<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login;
use App\Http\Controllers\AdminHome;
use App\Http\Controllers\BagGudang;
use App\Http\Controllers\BagPengiriman;
use App\Http\Controllers\Manajer;
use App\Http\Controllers\KotaKabupaten;
use App\Http\Controllers\Kecamatan;
use App\Http\Controllers\Kelurahan;
use App\Http\Controllers\SubAgen;
use App\Http\Controllers\Customer;
use App\Http\Controllers\CalonCustomer;
use App\Http\Controllers\GudangHome;
use App\Http\Controllers\Gas;
use App\Http\Controllers\PenjualanHome;
use App\Http\Controllers\SubAgenHome;
use App\Http\Controllers\OrderCus;
use App\Http\Controllers\Frontend;
use App\Http\Controllers\Pemesanan;
use App\Http\Controllers\Pengiriman;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::any('/', [Login::class, 'index'])->name('index');
Route::any('/produk', [Login::class, 'produk'])->name('produk');
Route::any('/register', [Login::class, 'form_register'])->name('register');
Route::any('/kecamatan', [Login::class, 'kecamatan'])->name('kecam');
Route::any('/kelurahan', [Login::class, 'kelurahan'])->name('kelur');
Route::any('/proses_daftar', [Login::class, 'proses_daftar'])->name('daftar');
Route::any('/form_login', [Login::class, 'form_login'])->name('form_login');
Route::any('/proseslogin',[Login::class, 'proseslogin'])->name('login');

Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->middleware(['admin'])->group(function () {
        Route::get('/home', [AdminHome::class, 'index'])->name('home_admin');
        Route::get('/profile{id}', [AdminHome::class, 'setting'])->name('setting_admin');
        Route::any('/profile_update', [AdminHome::class, 'setting_aksi'])->name('setting_aksi');
        Route::get('/informasi{id}', [AdminHome::class, 'informasi'])->name('informasi');
        Route::any('/informasi_update', [AdminHome::class, 'informasi_aksi'])->name('informasi_aksi');
         Route::get('/logout', [AdminHome::class, 'logout'])->name('logout_admin');

            Route::prefix('bagian_gudang')->group( function (){
                 Route::any('/data_bagian_gudang',[BagGudang::class, 'index'])->name('gudang');
                 Route::any('/simpan_data_bag_gudang', [BagGudang::class, 'simpan_data_gudang'])->name('simpan_gudang');
                 Route::any('/update_data_bag_gudang',[BagGudang::class, 'update_data_gudang'])->name('update_gudang');
                 Route::any('/hapus_data_gudang{id}',[BagGudang::class, 'destroy'])->name('hapus_gudang');
             });
            Route::prefix('bagian_penjualan')->group( function (){
                 Route::any('/data_bagian_pengiriman',[BagPengiriman::class, 'index'])->name('penjualan');
                 Route::any('/simpan_data_bag_pengiriman', [BagPengiriman::class, 'simpan_data_penjualan'])->name('simpan_penjualan');
                 Route::any('/update_data_bag_pengiriman',[BagPengiriman::class, 'update_data_penjualan'])->name('update_penjualan');
                 Route::any('/hapus_data_pengiriman{id}',[BagPengiriman::class, 'destroy'])->name('hapus_penjualan');
             });
            Route::prefix('manajer')->group( function (){
                 Route::any('/data_manajer',[Manajer::class, 'index'])->name('manajer');
                 Route::any('/simpan_data_manajer', [Manajer::class, 'simpan_data_manajer'])->name('simpan_manajer');
                 Route::any('/update_data_manajer',[Manajer::class, 'update_data_manajer'])->name('update_manajer');
                 Route::any('/hapus_data_manajer{id}',[Manajer::class, 'destroy'])->name('hapus_manajer');
             });
            Route::prefix('kota_kabupaten')->group( function (){
                 Route::any('/data_kota_kabupaten', [KotaKabupaten::class, 'index'])->name('data_kota');
                 Route::any('/simpan_data_kota', [KotaKabupaten::class, 'simpan_data_kota'])->name('simpan_kota');
                 Route::any('/edit_data_kota', [KotaKabupaten::class, 'edit_kota'])->name('edit_kota');
                 Route::any('/hapus_data_kota{id_kota}', [KotaKabupaten::class, 'hapus_kota'])->name('hapus_kota');
             });
            Route::prefix('kecamatan')->group( function (){
                 Route::any('/data_kecamatan{id_kota}', [Kecamatan::class, 'index'])->name('data_kec');
                 Route::any('/simpan_data_kecamatan', [Kecamatan::class, 'simpan_kecamatan'])->name('simpan_kec');
                 Route::any('/edit_data_kecamatan', [Kecamatan::class, 'edit_kecamatan'])->name('edit_kec');
                 Route::any('/hapus_data_kecamatan{id_kecamatan}', [Kecamatan::class, 'hapus_kecamatan'])->name('hapus_kec');
             });
            Route::prefix('kelurahan')->group( function (){
                 Route::any('/data_kelurahan{id_kecamatan}', [Kelurahan::class, 'index'])->name('data_kel');
                 Route::any('/simpan_data_kelurahan', [Kelurahan::class, 'simpan_kelurahan'])->name('simpan_kel');
                 Route::any('/edit_data_kelurahan', [Kelurahan::class, 'edit_kelurahan'])->name('edit_kel');
                 Route::any('/hapus_data_kelurahan{id_kelurahan}', [Kelurahan::class, 'hapus_kelurahan'])->name('hapus_kel');
             });
            Route::prefix('customer_wilayah')->group( function (){
                 Route::any('/data_customer_wilayah{id_kelurahan}', [SubAgen::class, 'index'])->name('data_cust');
                 Route::any('/tampil_edit_customer_wilayah{id_customer}', [SubAgen::class, 'tampil_data_edit_cust'])->name('tampil_edit_cust');
                 Route::any('/kecamatan', [SubAgen::class, 'kecamatan'])->name('kecama');
                 Route::any('/kelurahan', [SubAgen::class, 'kelurahan'])->name('kelura');
                 Route::any('/tampil_detail_data_sub{id_customer}', [SubAgen::class, 'tampil_data_detail_cust'])->name('tampil_detail');
                 Route::any('/simpan_data_customer_wilayah', [SubAgen::class, 'simpan_cust'])->name('simpan_cust');
                 Route::any('/edit_data_customer_wilayah', [SubAgen::class, 'edit_cust'])->name('edit_cust');
                 Route::any('/hapus_data_customer_wilayah{id_customer}', [SubAgen::class, 'hapus_cust'])->name('hapus_cust');
             });
            Route::prefix('customer')->group( function (){
                 Route::any('/data_customer', [Customer::class, 'index'])->name('data_cus');
                 Route::any('/kecamatan', [Customer::class, 'kecamatan'])->name('keca');
                 Route::any('/kelurahan', [Customer::class, 'kelurahan'])->name('kelu');
                 Route::any('/simpan_customer', [Customer::class, 'simpan_cus'])->name('simpan_cus');
                 Route::any('/tampil_edit_customer{id_customer}', [Customer::class, 'tampil_data_edit'])->name('tampil_edit_cus');
                 Route::any('/tampil_detail_customer{id_customer}', [Customer::class, 'tampil_data_detail'])->name('tampil_detail_cus');
                 Route::any('/edit_data_customer', [Customer::class, 'edit_customer'])->name('edit_cus');
                 Route::any('/hapus_data_customer{id_customer}', [Customer::class, 'hapus_customer'])->name('hapus_cus');
             });
            Route::prefix('calon_customer')->group( function (){
                 Route::any('/data_calon_customer', [CalonCustomer::class, 'index'])->name('data_calon');
                 Route::any('/tampil_detail_calon_customer{id_customer}', [CalonCustomer::class, 'tampil_detail_calon'])->name('detail_calon');
                 Route::any('/aktif_data_calon_customer', [CalonCustomer::class, 'aktif_calon_customer'])->name('aktif_calon');
                 Route::any('/hapus_data_calon_customer{id_customer}', [CalonCustomer::class, 'hapus_calon_customer'])->name('hapus_calon');
             });
            Route::prefix('pemesanan')->group( function (){
                Route::any('/data_pemesanan', [Pemesanan::class, 'data_pesanan'])->name('data_pemesanan');
                Route::any('/detail_data_pemesanan{id_pemesanan}', [Pemesanan::class, 'detail_data_pemesanan'])->name('detail_data_pemesanan');
                Route::any('/kirim_produk', [Pemesanan::class, 'kirim_produk'])->name('kirim_produk');
                Route::any('/tolak_pemesanan', [Pemesanan::class, 'tolak_pemesanan'])->name('tolak_pemesanan');
                 Route::any('/data_penjualan', [Pemesanan::class, 'data_penjualan'])->name('data_penjualan');
                 Route::any('/detail_data_penjualan{id_pemesanan}', [Pemesanan::class, 'detail_penjualan'])->name('detail_penjualan');
                 Route::any('/laporan_penjualan', [Pemesanan::class, 'laporan_penjualan'])->name('laporan_penjualan');
            });
    });
 
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('gudang')->middleware(['gudang'])->group(function () {
        Route::get('/home', [GudangHome::class, 'index'])->name('home_gudang');
         Route::get('/logout', [GudangHome::class, 'logout'])->name('logout_gudang');

             Route::prefix('gas')->group( function (){
                 Route::any('/data_gas', [Gas::class, 'index'])->name('data_gas');
                 Route::any('/data_histori', [Gas::class, 'data_histori'])->name('data_histori');
                 Route::any('/simpan_data_gas', [Gas::class, 'simpan_data_gas'])->name('simpan_gas');
                 Route::any('/tampil_edit_data_gas{id_gas}', [Gas::class, 'tampil_edit_data_gas'])->name('tampil_edit');
                 Route::any('/edit_data_gas', [Gas::class, 'edit_data_gas'])->name('edit_gas');
                 Route::any('/hapus_data_gas{id_gas}', [Gas::class, 'hapus_data_gas'])->name('hapus_gas');
                 Route::any('/tambah_stok_gas', [Gas::class, 'tambah_stok_gas'])->name('tambah_gas');
                 Route::any('/kurangi_stok_gas', [Gas::class, 'kurang_stok_gas'])->name('kurang_gas');
                 Route::any('/cetak_laporan_produk', [Gas::class, 'laporan_produk'])->name('laporan_produk');
             });

    });
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('pengiriman')->middleware(['penjualan'])->group(function () {
        Route::get('/home', [PenjualanHome::class, 'index'])->name('home_penjualan');
        Route::any('/data_pengiriman', [Pengiriman::class, 'data_pengiriman'])->name('data_pengiriman');
        Route::any('/detail_data_pengiriman{id_pemesanan}', [Pengiriman::class, 'detail_data_pengiriman'])->name('detail_data_pengiriman');
        Route::any('/selesai_pengiriman', [Pengiriman::class, 'selesai_kirim'])->name('selesai');
        Route::any('/batalkan_pengiriman{id_pemesanan}', [Pengiriman::class, 'batal_kirim'])->name('batalkan');
         Route::get('/logout', [PenjualanHome::class, 'logout'])->name('logout_penjualan');

             

    });
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('customer')->middleware(['customer'])->group(function () {
        Route::get('/home', [Frontend::class, 'index'])->name('home_customer');
        Route::get('/produk', [Frontend::class, 'produk'])->name('produk_customer');
        Route::get('/profile{id}', [Frontend::class, 'setting'])->name('setting_customer');
        Route::get('/logout', [Frontend::class, 'logout'])->name('logout_customer');
        Route::any('/kecamatan', [Frontend::class, 'kecamatan'])->name('keca');
        Route::any('/kelurahan', [Frontend::class, 'kelurahan'])->name('kelu');
        Route::any('/edit_profile', [Frontend::class, 'edit_customer'])->name('update_profile');

        Route::prefix('pemesanan')->group( function (){
                 Route::any('/form{no_invoice}', [Frontend::class, 'form_pemesanan'])->name('form');
                 Route::any('/pesan', [Frontend::class, 'pesan'])->name('pesan');
                 Route::any('/update_pesanan', [Frontend::class, 'update_pemesanan'])->name('update_pemesanan');
                 Route::any('/tambah_pesanan', [Frontend::class, 'tambah_pemesanan'])->name('tambah_pemesanan');
                 Route::any('/hapus_pesanan{id_detail_pemesanan}', [Frontend::class, 'hapus_pemesanan'])->name('hapus_pemesanan');
                 Route::any('/buat_pesanan', [Frontend::class, 'buat_pemesanan'])->name('buat_pemesanan');
                 Route::any('/cancel_pesanan', [Frontend::class, 'cancel_pemesanan'])->name('cancel_pemesanan');
                 Route::any('/data_pesanan{id}', [Frontend::class, 'data_pesanan'])->name('data_pesanan');
                 Route::any('/detail_data_pesanan{id_pemesanan}', [Frontend::class, 'detail_data_pesanan'])->name('detail_data_pesanan');
                 Route::any('/cetak_data_pesanan{id_pemesanan}', [Frontend::class, 'cetak_data_pesanan'])->name('cetak_data_pesanan');
                 Route::any('/konfirmasi_pesanan_selesai{id_pemesanan}', [Frontend::class, 'konfirmasi_selesai'])->name('konfirmasi_selesai');
             });
             });
    });