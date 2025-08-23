<?php

namespace App\Http\Controllers;

use App\Models\ModelMedicoEspecialidade;
use App\Models\ModelValorConsulta;
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
        $oModelValorConsulta->setEspecialidadeId($request->especialidade);
        $oModelValorConsulta->setMedicoId($this->getUsuarioLogado()->id);
        $oModelValorConsulta->setValor($request->valor);

        if($oModelValorConsulta->save()){
            return $this->getMensagemInsercaoOk();
        }

        return $this->getMessageInsercaoError();
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
            $oModelValorConsulta->setEspecialidadeId($request->especialidade);
        }

        if($request->filled('valor')){
            $oModelValorConsulta->setValor($request->valor);
        }

        if($oModelValorConsulta->save()){
            return $this->getMessageAlteracaoSucesso();
        }

        return $this->getMessageAlteracaoError();
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'integer|required'
        ]);

        $oModelValorConsulta = ModelValorConsulta::find($request->id);

        if($oModelValorConsulta->delete()){
            return $this->getMessageDeleteSucesso();
        }

        return $this->getMessageDeleteError();
    }

}