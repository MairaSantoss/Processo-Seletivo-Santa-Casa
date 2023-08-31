<?php

namespace App\Http\Controllers;

use App\Models\Especialidade;
use Illuminate\Http\Request;

class EspecialidadesController extends Controller
{
    public function index(){
        //  dd('hello');
        $especialidade = Especialidade::all();
        dd($especialidade);
        return view('especialidades');
    }
}
