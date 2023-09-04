<?php

namespace App\Http\Controllers;
use App\Models\Especialidade;
use Illuminate\Http\Request;
use Validator;

class EspecialidadesController extends Controller
{
    public function index(Request $request){
        $data = Especialidade::all('*');
        if ($request->ajax()) {
            return \Yajra\DataTables\DataTables::of($data)->addIndexColumn()
            ->addColumn('action', function($data){
                $button = '<a  href="#" onclick="ModalEditar(this.id)"  id="'.$data->id.'" class=" BotaoTabela btn-primary btn-sm"> <i class="fas fa-edit fa-lg"></i></a>';
                $button .= '<a href="#" onclick="ModalApagar(this.id)"  id="'.$data->id.'" class=" BotaoTabela  btn-primary btn-sm"> <i class="fas fa-trash-alt fa-lg"></i></a>';
                return $button;
            })
            ->make(true);
        }
        return view('especialidades');
    }

    public function store(Request $request)
    {
        $rules = array(
            'nome'    =>  'required',
            'descricao'     =>  'required',
        );
        $error = Validator::make($request->all(), $rules);
        if($error->fails()){
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $form_data = array(
            'nome'         =>  $request->nome,
            'descricao'         =>  $request->descricao
        );
        Especialidade::create($form_data);
        return response()->json(['success' => 'Adicionado com sucesso!']);
        
    }

    public function edit($id)
    {
        if(request()->ajax()) {
            $data = Especialidade::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request)
    {
        $rules = array(
            'nome'    =>  'required',
            'descricao'     =>  'required',
        );
        $error = Validator::make($request->all(), $rules);
        if($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $form_data = array(
            'nome'    =>  $request->nome,
            'descricao'     =>  $request->descricao
        );
        Especialidade::whereId($request->hidden_id)->update($form_data);
        return response()->json(['success' => 'Editado com sucesso!']);
    }
    
    public function destroy($id)
    {
        $data = Especialidade::findOrFail($id);
        $data->delete();
    }

    public function select()
    {
        $especialidades = Especialidade::all('*');
        return response()->json($especialidades);
    }
}
