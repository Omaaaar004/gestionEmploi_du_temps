<?php
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Routes;
use App\Http\Controllers\ComposanteController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\LocalController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\FiliereController;
use App\Http\Controllers\EtapeController;
use App\Http\Controllers\ProfController;
use App\Http\Controllers\SeanceController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\SemestreController;

Route::get('/',function(){
    return view('layouts.app');

});

Route::get('/seances/events', [SeanceController::class, 'events'])->name('seances.events');
Route::get('/seances/modules/{filiere}', [SeanceController::class, 'getModulesByFiliere'])->name('seances.modules.by.filiere');

Route::resource('composantes',composanteController::class);
Route::resource('zones',zoneController::class);
Route::resource('locals',localController::class);
Route::resource('departements',departementController::class);
Route::resource('filieres',filiereController::class);
Route::resource('etapes',etapeController::class);
Route::resource('profs',profController::class);
Route::resource('seances',seanceController::class);
Route::resource('modules',ModuleController::class);
Route::resource('semestres',SemestreController::class);