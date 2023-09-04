<?php

use App\Http\Controllers\MedicosController;
use App\Http\Controllers\EspecialidadesController;
use App\Http\Controllers\RelatoriosController;

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
})->name('santacasa.welcome');

Route::prefix('especialidades')->group(function () {
    Route::get('/', [EspecialidadesController::class , 'index'] )->name('especialidades.index');
    Route::post('/store', [EspecialidadesController::class , 'store'] )->name('especialidades.store');
    Route::get('/edit/{id}/', [EspecialidadesController::class, 'edit'])->name('especialidades.edit');
    Route::post('/update', [EspecialidadesController::class, 'update'])->name('especialidades.update');
    Route::get('/destroy/{id}/', [EspecialidadesController::class, 'destroy'])->name('especialidades.destroy');
    Route::get('/select', [EspecialidadesController::class, 'select'])->name('especialidades.select');
});

Route::prefix('medicos')->group(function () {
    Route::get('/', [MedicosController::class , 'index'] )->name('medicos.index');
    Route::post('/store', [MedicosController::class , 'store'] )->name('medicos.store');
    Route::get('/edit/{id}/', [MedicosController::class, 'edit'])->name('medicos.edit');
    Route::post('/update', [MedicosController::class, 'update'])->name('medicos.update');
    Route::get('/destroy/{id}/', [MedicosController::class, 'destroy'])->name('medicos.destroy');
    Route::get('/selectCRM',  [MedicosController::class, 'selectCRM'] )->name('medicos.selectCRM');

});

Route::prefix('relatorios')->group(function () {
    Route::get('/', [RelatoriosController::class , 'relatorioMedicoEspecialidade'])->name('relatorios.relatorioMedicoEspecialidade');
    Route::get('/filtroRelatorio/{crm_medico}/{especialidades}', [RelatoriosController::class , 'filtroRelatorio'])->name('relatorios.filtroRelatorio');
});

