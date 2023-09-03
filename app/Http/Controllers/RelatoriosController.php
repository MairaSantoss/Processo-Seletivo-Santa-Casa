<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class RelatoriosController extends Controller
{
    public function index(Request $request)
    {
      // $medicos = Medico::with('especialidades')->get();
        
       return view('relatorios');
    }
    
}
