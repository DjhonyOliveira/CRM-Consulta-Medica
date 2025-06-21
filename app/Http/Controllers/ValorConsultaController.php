<?php

namespace App\Http\Controllers;

use App\Models\ModelMedicoEspecialidade;
use App\Models\ModelValorConsulta;
use Exception;
use Illuminate\Http\Request;

class ValorConsultaController extends Controller
{
 
    public function renderView()
    {
        return view('valorConsulta');
    }

    public function create(Request $request)
    {
        $request->validate([
            'valor'         => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'especialidade' => 'integer|required'
        ]);

        if(!ModelMedicoEspecialidade::validaMedicoEspecialidade($request->especialidade)){
            return response()->json([
                "message" => "Especialidade informada não esta relacionada com suas especialidades cadastradas",
                "type"    => "warning"
            ]);
        }

        $oModelValorConsulta = new ModelValorConsulta();
        $oModelValorConsulta->especialidade_id = $request->especialidade;
        $oModelValorConsulta->medico_id        = auth()->user()->id;
        $oModelValorConsulta->valor            = $request->valor;

        if($oModelValorConsulta->save()){
            return response()->json([
                "message" => "Valor da consulta salvo com sucesso!"
            ]);
        }

        return response()->json([
            "message" => "Erro ao salvar o registro, tente novamente mais tarde",
        ], 404);
    }

    public function update(Request $request)
    {
        $request->validate([
            "id"            => "integer|required",
            "especialidade" => "integer",
            "valor"         => ['numeric', 'regex:/^\d+(\.\d{1,2})?$/']
        ]);

        if(!ModelMedicoEspecialidade::validaMedicoEspecialidade($request->especialidade)){
            return response()->json([
                "message" => "Especialidade informada não esta relacionada com suas especialidades cadastradas",
                "type"    => "warning"
            ]);
        }

        $oModelValorConsulta = ModelValorConsulta::find($request->id);

        if($request->filled('especialidade')){
            $oModelValorConsulta->especialidade_id = $request->especialidade;
        }

        if($request->filled('valor')){
            $oModelValorConsulta->valor = $request->valor;
        }

        if($oModelValorConsulta->save()){
            return response()->json([
                "message" => "Valor da consulta alterado com sucesso!"
            ]);
        }

        return response()->json([
            "message" => "Erro ao salvar o registro, tente novamente mais tarde"
        ], 404);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'integer|required'
        ]);

        $oModelValorConsulta = ModelValorConsulta::find($request->id);

        if($oModelValorConsulta->delete()){
            return response()->json([
                "message" => "Registro deletado com sucesso"
            ]);
        }

        return response()->json([
            "message" => "Erro ao deletar o registro",
        ], 404);
    }
}