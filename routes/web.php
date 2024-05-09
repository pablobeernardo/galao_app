<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EncherGalaoController;


Route::get('/', [EncherGalaoController::class, 'index'])->name('encher_galao.index');
Route::post('/store', [EncherGalaoController::class, 'store'])->name('encher_galao.store');

