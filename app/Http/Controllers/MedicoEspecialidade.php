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

        $userLogado = $this->getUsuarioLogado();

        if(!$userLogado->isMedico()){
            return response()->json([
                "message" => "Você deve ser um médico para conseguir realizar o cadastro de especialidade",
                "type"    => "warning"
            ]);
        }

        $oModelEspecialidadeMedico = new ModelMedicoEspecialidade();
        $oModelEspecialidadeMedico->setMedicoId($userLogado->id);
        $oModelEspecialidadeMedico->setEspecialidadeId($request->especialidade_id);

        if($oModelEspecialidadeMedico->save()){
            return $this->getMensagemInsercaoOk();
        }

        return $this->getMessageInsercaoError();
    }

    public function delete(Request $request)
    {
        $idEspecialidade = $request->id;

        $medicoEspecialidade = DB::table('medico_especialidade')
                                 ->where('medico_id', $this->getUsuarioLogado())
                                 ->where('especialidade_id', $idEspecialidade);

        if($medicoEspecialidade){
            if($medicoEspecialidade->delete()){
                return $this->getMessageDeleteSucesso();
            }
        }
        
        return $this->getMessageDeleteError();
    }

}