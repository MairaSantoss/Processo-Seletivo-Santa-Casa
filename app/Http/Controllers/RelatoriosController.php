<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medico;

class RelatoriosController extends Controller
{
  public function relatorioMedicoEspecialidade(Request $request)
  {
     // $data = Medico::with('especialidades')->get('id, nome, CRM, telefone');
    $data = Medico::with('especialidades')->get('*');
    //die($data);
      if ($request->ajax()) {
        return \Yajra\DataTables\DataTables::of($data)->addIndexColumn()
            ->addColumn('action', function($data){
                $button = '<a onclick="VisualizarTudo(this.id)" name="read" id="'.$data->id.'" class="read btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>read</a>';
                return $button;
            })
            ->addColumn('especialidades', function ($data) {
              $especialidades = $data->especialidades; // Array de objetos de especialidades
              $nomesEspecialidades = [];
              foreach ($especialidades as $especialidade) {
                  $nomesEspecialidades[] = $especialidade->nome;
              }
              $especialidadesString = implode(', ', $nomesEspecialidades);
              $especialidadesString = limitarComTresPontos($especialidadesString, 20); 
              return $especialidadesString;
          })
            ->make(true);
    }
      return view('relatorios');
  }

  public function filtroRelatorio(Request $request)
{
    $query = Medico::with('especialidades');
    $a = 0;

    if($request->crm_medico != 'null' && $request->especialidades != 'null'){
      $query->where('CRM', '=', $request->crm_medico)
      ->whereHas('especialidades', function ($subquery) use ($request) {
          $subquery->where('id', '=', $request->especialidades);
      });
    }
    elseif ($request->crm_medico != 'null' && $request->especialidades == 'null' ) {
      $a= 5;
      $query->where('CRM', '=', $request->crm_medico);
    } 
    elseif ($request->crm_medico == 'null' && $request->especialidades != 'null' ) {
      $a= 6;
      $query->whereHas('especialidades', function ($subquery) use ($request) {
          $subquery->where('id', '=', $request->especialidades );
      });
    }
    //$data = $query->get(); // Obtenha os dados após aplicar os filtros

   // die($request->crm_medico );
    if ($request->ajax()) {
        return \Yajra\DataTables\DataTables::of($query)->addIndexColumn()
            ->addColumn('action', function ($data) {
                $button = '<a onclick="VisualizarTudo(this.id)" name="read" id="' . $data->id . '" class="read btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>read</a>';
                return $button;
            })
            ->addColumn('especialidades', function ($data) {
                $especialidades = $data->especialidades; // Collection de objetos de especialidades
                $nomesEspecialidades = [];
                foreach ($especialidades as $especialidade) {
                    $nomesEspecialidades[] = $especialidade->nome;
                }
                $especialidadesString = implode(', ', $nomesEspecialidades);
                $especialidadesString = limitarComTresPontos($especialidadesString, 20);
                return $especialidadesString;
            })
            ->make(true);
    }

}

  
  


}

function limitarComTresPontos($texto, $limite) {
  if (strlen($texto) <= $limite) {
      return $texto;
  } else {
      $texto = substr($texto, 0, $limite - 3) . '...';
      return $texto;
  }
}