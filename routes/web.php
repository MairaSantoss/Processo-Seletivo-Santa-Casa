<?php

use App\Http\Controllers\MedicosController;
use App\Http\Controllers\EspecialidadesController;

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

//php artisan make:controller MedicosController
//php artisan make:migration especialidades          
Route::get('/', function () {
    return view('welcome');
});

Route::get('/medicos', [MedicosController::class , 'index'] )->name('medicos.index');

Route::get('/especialidades', [EspecialidadesController::class , 'index'] )->name('especialidades.index');

Route::view('/medico_especialidades', 'medico_especialidades')->name('medico_especialidades.index');

