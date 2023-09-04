<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Medico;

class RelatoriosController extends Controller
{
  public function relatorioMedicoEspecialidade(Request $request)
  {
    $data = Medico::with('especialidades')->get('*');
    if ($request->ajax()) {
      return \Yajra\DataTables\DataTables::of($data)->addIndexColumn()
      ->addColumn('action', function($data){
          $button = '<a href="#" class="BotaoTabela" onclick="VisualizarTudo(this.id)" id="'.$data->id.'" > <i class="fas fa-eye fa-lg"></i></a>';
          return $button;
        })
      ->addColumn('especialidades', function ($data) {
          $especialidades = $data->especialidades; 
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
    if($request->crm_medico != 'null' && $request->especialidades != 'null'){
      $query->where('CRM', '=', $request->crm_medico)
      ->whereHas('especialidades', function ($subquery) use ($request) {
          $subquery->where('id', '=', $request->especialidades);
      });
    }
    elseif ($request->crm_medico != 'null' && $request->especialidades == 'null' ) {
      $query->where('CRM', '=', $request->crm_medico);
    } 
    elseif ($request->crm_medico == 'null' && $request->especialidades != 'null' ) {
      $query->whereHas('especialidades', function ($subquery) use ($request) {
          $subquery->where('id', '=', $request->especialidades );
      });
    }
    if ($request->ajax()) {
      return \Yajra\DataTables\DataTables::of($query)->addIndexColumn()
      ->addColumn('action', function ($data) {
          $button = '<a href="#" class="BotaoTabela" onclick="VisualizarTudo(this.id)" id="' . $data->id . '" ><i class="fas fa-eye fa-lg"></i></a>';
          return $button;
        })
      ->addColumn('especialidades', function ($data) {
          $especialidades = $data->especialidades; 
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