<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EspecialidadesController extends Controller
{
    public function index(){
        //  dd('hello');
        return view('especialidades');
    }
}
