<?php

namespace App\Http\Controllers;
use App\Models\Medico;
use Illuminate\Http\Request;
use Validator;

class MedicosController extends Controller
{
    public function index(Request $request){
        $data = Medico::all('*');
        if ($request->ajax()) {
            return \Yajra\DataTables\DataTables::of($data)->addIndexColumn()
            ->addColumn('action', function($data){
                $button = '<a  href="#" onclick="ModalEditar(this.id)"  id="'.$data->id.'" class=" BotaoTabela btn-primary btn-sm"> <i class="fas fa-edit fa-lg"></i></a>';
                $button .= '<a href="#" onclick="ModalApagar(this.id)"  id="'.$data->id.'" class=" BotaoTabela  btn-primary btn-sm"> <i class="fas fa-trash-alt  fa-lg"></i></a>';

                $button .= '<a href="#" class="BotaoTabela" onclick="VisualizarTudo(this.id)" id="'.$data->id.'" > <i class="fas fa-eye fa-lg"></i></a>';

                return $button;
            })
            ->make(true);
        }
        return view('medicos');
    }

    public function store(Request $request)
    {
        $rules = array(
            'nome' => 'required',
            'CRM' => 'required',
            'telefone' => 'required',
            'email' => 'required',
        );
        $error = Validator::make($request->all(), $rules);
        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $especialidades = json_decode($request->especialidades);
        if( count($especialidades) == 0){ return response()->json(['errors' => ['Especialidades não pode ser vazia.'] ]);}
        $form_data = array(
            'nome' => $request->nome,
            'CRM' => $request->CRM,
            'telefone' => $request->telefone,
            'email' => $request->email,
        );
        $medico = Medico::create($form_data);
        if (!empty($especialidades) && is_array($especialidades)) {
            $medico->especialidades()->attach($especialidades);
        }
        return response()->json(['success' => 'Adicionado com sucesso!']);
    }

    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Medico::findOrFail($id);
            $especialidadesDoMedico = $data->especialidades;
            return response()->json(['result' => $data, 'result2' =>$especialidadesDoMedico ]);
        }
    }

    public function update(Request $request)
    {
        $rules = array(
            'nome' => 'required',
            'CRM' => 'required',
            'telefone' => 'required',
            'email' => 'required'
        );
        $error = Validator::make($request->all(), $rules);
        if($error->fails())  {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $especialidades = json_decode($request->especialidades);
        if( count($especialidades) == 0){ return response()->json(['errors' => ['Especialidades não pode ser vazia.'] ]);}
        $form_data = array(
            'nome'         =>  $request->nome,
            'CRM'         =>  $request->CRM,
            'telefone'         =>  $request->telefone,
            'email'         =>  $request->email
        );
        Medico::whereId($request->hidden_id)->update($form_data);
        $medico = Medico::find($request->hidden_id);
        $medico->especialidades()->sync($especialidades);
        return response()->json(['success' => 'Editado com sucesso!']);
    }

    public function destroy($id)
    {
        $data = Medico::findOrFail($id);
        $data->delete();
    }

    public function selectCRM()
    {
        $crms = Medico::pluck('CRM')->toArray();
        return response()->json($crms); 
    }
}
