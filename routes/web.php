<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EncherGalaoController;


Route::get('/', [EncherGalaoController::class, 'index'])->name('encher_galao.index');
Route::post('/store', [EncherGalaoController::class, 'store'])->name('encher_galao.store');
Route::get('/registros', [EncherGalaoController::class, 'registros'])->name('encher_galao.registros');
Route::post('/exportar-csv', [EncherGalaoController::class, 'exportarCSV'])->name('exportar_csv');
Route::post('/enviar-email', [EncherGalaoController::class, 'enviarEmail'])->name('enviar_email');


