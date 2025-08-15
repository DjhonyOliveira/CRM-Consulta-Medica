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
            return $this->getMensagemInsercaoOk();
        }

        return $this->getMessageInsercaoError();
    }

    public function update(Request $request)
    {
        $idEspecialidade     = $request->id;
        $oModelEspecialidade = ModelEspecialidade::find($idEspecialidade);

        if($request->filled('nome')){
            $oModelEspecialidade->nome = $request->nome;
        }

        if($oModelEspecialidade->save()){
            return $this->getMessageAlteracaoSucesso();
        }

        return $this->getMessageAlteracaoError();
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
            return $this->getMessageDeleteSucesso();
        }

        return $this->getMessageDeleteError();
    }

}