<?php

namespace App\Http\Controllers;

use App\Models\ModelEspecialidade;
use Illuminate\Http\Request;

class EspecialidadeController extends Controller
{

    public function renderView()
    {
        return view('especialidades');
    }

    public function create(Request $request)
    {
        $request->validate([
            "nome" => 'required|string|max:255'
        ]);

        $oModelEspecialidade = new ModelEspecialidade();
        $oModelEspecialidade->nome = $request->nome;

        if($oModelEspecialidade->save()){
            return response()->json([
                "message" => "Especialidade inserida com sucesso!"
            ]);
        }

        response()->json([
            "message" => "Falha ao inserir o registro, tente novamente."
        ], 404);
    }

    public function update(Request $request)
    {
        $idEspecialidade     = $request->id;
        $oModelEspecialidade = ModelEspecialidade::find($idEspecialidade);

        if($request->filled('nome')){
            $oModelEspecialidade->nome = $request->nome;
        }

        if($oModelEspecialidade->save()){
            return response()->json([
                "message" => "Especialidade alterada com sucesso!"
            ]);
        }

        return response()->json([
            "message" => "Falha para atualizar o registro, tente novamente!",
        ], 404);
    }

    public function delete(Request $request)
    {
        $idEspecialidade     = $request->input('id');
        $oModelEspecialidade = ModelEspecialidade::find($idEspecialidade);

        if(!$oModelEspecialidade){
            return response()->json([
                "message" => "Não foi possivel localizar a especilidade informada, atualize a página e tente novamente",
                "type"    => "warning"
            ]);
        }

        if($oModelEspecialidade->delete()){
            return response()->json([
                "message" => "Especialidade deletada com sucesso!",
            ]);
        }

        return response()->json([
            "message" => "Falha ao deletar a especilidade, tente novamente!",
        ], 404);
    }

}