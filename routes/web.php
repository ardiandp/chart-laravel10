<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BankChartController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/bank-chart', [BankChartController::class, 'index']);

Route::get('/bank-mutasi', [BankChartController::class, 'mutasi']);

Route::get('/bank-total-mutasi', [BankChartController::class, 'totalMutasi']);

Route::get('/bank-total-mutasi-periode', [BankChartController::class, 'totalMutasiPerBulan']);

// Route untuk total mutasi per tahun
Route::get('/bank-total-mutasi-tahun', [BankChartController::class, 'totalMutasiPerTahun']);
Route::get('/bank-mutasi-harian', [BankChartController::class, 'mutasiHarian']);