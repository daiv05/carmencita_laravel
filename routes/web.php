<?php

use App\Http\Controllers\ImpresionController;
use Illuminate\Support\Facades\Route;

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

Route::get(
    '/ver_factura',
    [ImpresionController::class, 'ver_factura']
)->name('impresion_facturas');

Route::get(
    '/ver_credito',
    [ImpresionController::class, 'ver_credito']
)->name('impresion_creditos');

Route::get(
    '/ver_hoja_de_ruta/{id_hoja_de_ruta}',
    [ImpresionController::class, 'ver_hr_blade']
)->name('impresion_hoja_de_ruta');
