<?php

namespace App\Http\Controllers;

use App\Models\Especialidade;
use Illuminate\Http\Request;
use DataTables;
use Validator;

class EspecialidadesController extends Controller
{
    public function index(Request $request){

      $data = Especialidade::all('*');

      if ($request->ajax()) {
        $especialidade = Especialidade::all('*');
        return DataTables::of($data)->addIndexColumn()
            ->addColumn('action', function($data){
                $button = '<a onclick="ModalEditar(this.id)" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</a>';

                $button .= '<a onclick="ModalApagar(this.id)" name="edit" id="'.$data->id.'" class="delet btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Apagar</a>';

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
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $form_data = array(
            'nome'         =>  $request->nome,
            'descricao'         =>  $request->descricao
        );
        Especialidade::create($form_data);
        return response()->json(['success' => 'Data Added successfully.']);
        
    }

    public function edit($id)
    {
        if(request()->ajax())
        {
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
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $form_data = array(
            'nome'    =>  $request->nome,
            'descricao'     =>  $request->descricao
        );
        Especialidade::whereId($request->hidden_id)->update($form_data);
        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function destroy($id)
    {
        $data = Especialidade::findOrFail($id);
        $data->delete();
    }
    
}
