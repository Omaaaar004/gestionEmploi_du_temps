<?php

use Illuminate\Support\Facades\Routes;
use App\Http\Controllers\composanteController;
use App\Http\Controllers\zoneController;
use App\Http\Controllers\localController;
use App\Http\Controllers\departementController;
use App\Http\Controllers\filiereController;
use App\Http\Controllers\etapeController;
use App\Http\Controllers\profController;
use App\Http\Controllers\seanceController;

Route::get('/',function(){
    return view('layouts.app');

});

Route::resource('composantes',composanteController::class);
Route::resource('zones',zoneController::class);
Route::resource('locals',localController::class);
Route::resource('departements',departementController::class);
Route::resource('filieres',filiereController::class);
Route::resource('etapes',etapeController::class);
Route::resource('modules',moduleController::class);
Route::resource('profs',profController::class);
Route::resource('seances',seanceController::class);