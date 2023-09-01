<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use Illuminate\Http\Request;
use DataTables;
use Validator;

class MedicosController extends Controller
{
    public function index(Request $request){
        $data = Medico::all('*');
        if ($request->ajax()) {
            $Medico = Medico::all('*');
            return DataTables::of($data)->addIndexColumn()
            ->addColumn('action', function($data){
                $button = '<a onclick="ModalEditar(this.id)" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Edit</a>';

                $button .= '<a onclick="ModalApagar(this.id)" name="edit" id="'.$data->id.'" class="delet btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i>Apagar</a>';

                return $button;
            })
            ->make(true);
        }
        return view('Medicos');
    }


    public function store(Request $request)
    {
        $rules = array(
            'nome' => 'required',
            'CRM' => 'required',
            'telefone' => 'required',
            'email' => 'required'
         //   'dt_cadastro' => 'required'
        );
        $error = Validator::make($request->all(), $rules);
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $form_data = array(
            'nome'         =>  $request->nome,
            'CRM'         =>  $request->CRM,
            'telefone'         =>  $request->telefone,
            'email'         =>  $request->email
            //'dt_cadastro' =>  8450350
        );
        Medico::create($form_data);
        return response()->json(['success' => 'Data Added successfully.']);
        
    }

    public function edit($id)
    {
        if(request()->ajax())
        {
            $data = Medico::findOrFail($id);
            return response()->json(['result' => $data]);
        }
    }

    public function update(Request $request)
    {
        $rules = array(
            'nome' => 'required',
            'CRM' => 'required',
            'telefone' => 'required',
            'email' => 'required'
        //   'dt_cadastro' => 'required'
        );
        $error = Validator::make($request->all(), $rules);
        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        $form_data = array(
            'nome'         =>  $request->nome,
            'CRM'         =>  $request->CRM,
            'telefone'         =>  $request->telefone,
            'email'         =>  $request->email
            //'dt_cadastro' =>  8450350
        );
        Medico::whereId($request->hidden_id)->update($form_data);
        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function destroy($id)
    {
        //die($id);
        $data = Medico::findOrFail($id);
        $data->delete();
    }
    
}
