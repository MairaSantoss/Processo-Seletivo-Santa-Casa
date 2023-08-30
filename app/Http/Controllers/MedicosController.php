<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MedicosController extends Controller
{
    public function index(){
      //  dd('hello');
        return view('medicos');
    }
}
