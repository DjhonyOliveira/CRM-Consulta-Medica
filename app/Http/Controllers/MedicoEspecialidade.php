<?php

namespace App\Http\Controllers;

use App\Models\ModelMedicoEspecialidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicoEspecialidade extends Controller
{

    public function renderView()
    {
        return view('medicoEspecialidade');
    }

    public function create(Request $request)
    {
        $request->validate([
            "especialidade_id" => "required|integer"
        ]);

        $userLogado = auth()->user();

        if(!$userLogado->isMedico()){
            return response()->json([
                "message" => "Você deve ser um médico para conseguir realizar o cadastro de especialidade",
                "type"    => "warning"
            ]);
        }

        $oModelEspecialidadeMedico = new ModelMedicoEspecialidade();
        $oModelEspecialidadeMedico->medico_id        = $userLogado->id;
        $oModelEspecialidadeMedico->especialidade_id = $request->especialidade_id;

        if($oModelEspecialidadeMedico->save()){
            return response()->json([
                "message" => "Especialidade inserida com sucesso para o médico " . $userLogado->name
            ]);
        }

        return response()->json([
            "message" => "Falha ao registrar a especialidade, tente novamente"
        ], 404);
    }

    public function delete(Request $request)
    {
        $idEspecialidade = $request->id;

        $medicoEspecialidade = DB::table('medico_especialidade')
                                 ->where('medico_id', auth()->user()->id)
                                 ->where('especialidade_id', $idEspecialidade);

        if($medicoEspecialidade){
            if($medicoEspecialidade->delete()){
                return response()->json([
                    "message" => "Especialidade removida com sucesso"
                ]);
            }
        }
        
        return response()->json([
            "message" => "falha ao remover a especialidade, tente novamente!",
        ], 404);
    }

}