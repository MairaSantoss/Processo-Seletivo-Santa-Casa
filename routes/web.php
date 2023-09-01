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

//Tabela
//php artisan make:migration create_medicos_table
//php atisan migrate

//class
//singular
//php artisan make:model Especialidade

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('especialidades')->group(function () {
    // Aqui você pode definir as rotas relacionadas a especialidades
    Route::get('/', [EspecialidadesController::class , 'index'] )->name('especialidades.index');
    Route::post('/store', [EspecialidadesController::class , 'store'] )->name('especialidades.store');
    Route::get('/edit/{id}/', [EspecialidadesController::class, 'edit'])->name('especialidades.edit');
    Route::post('/update', [EspecialidadesController::class, 'update'])->name('especialidades.update');
    Route::get('/destroy/{id}/', [EspecialidadesController::class, 'destroy'])->name('especialidades.destroy');
  //  Route::get('/', 'EspecialidadesController@index')->name('especialidades.index');
    //Route::get('/{id}', 'EspecialidadesController@show')->name('especialidades.show');
    // E assim por diante...
});

Route::get('/medicos', [MedicosController::class , 'index'] )->name('medicos.index');


Route::view('/medico_especialidades', 'medico_especialidades')->name('medico_especialidades.index');

