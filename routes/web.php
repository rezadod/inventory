<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect('home');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/tampi_barang', [App\Http\Controllers\HomeController::class, 'tampi_barang'])->name('tampi_barang');
Route::post('/save_input_barang', [App\Http\Controllers\HomeController::class, 'save_input_barang'])->name('save_input_barang');
Route::post('/save_edit_barang', [App\Http\Controllers\HomeController::class, 'save_edit_barang'])->name('save_edit_barang');
Route::post('/hapus_inventory', [App\Http\Controllers\HomeController::class, 'hapus_inventory'])->name('hapus_inventory');
Route::post('/hapus_data_inventory', [App\Http\Controllers\HomeController::class, 'hapus_data_inventory'])->name('hapus_data_inventory');
Route::post('/edit_inventory', [App\Http\Controllers\HomeController::class, 'edit_inventory'])->name('edit_inventory');
Route::post('/detail_inventory', [App\Http\Controllers\HomeController::class, 'detail_inventory'])->name('detail_inventory');
Route::post('/cek_produk', [App\Http\Controllers\HomeController::class, 'cek_produk'])->name('cek_produk');
Route::post('/cek_qty', [App\Http\Controllers\HomeController::class, 'cek_qty'])->name('cek_qty');

Route::get('/report_barang_keluar', [HomeController::class, 'report_barang_keluar']);
Route::post('/save_input_barang_keluar', [HomeController::class, 'save_input_barang_keluar']);
