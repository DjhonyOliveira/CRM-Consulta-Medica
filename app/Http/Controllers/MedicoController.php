<?php

namespace App\Http\Controllers;

use App\Models\ModelHorariosDisponiveis;
use App\Models\User;
use Illuminate\Http\Request;

class MedicoController extends Controller
{
    
    public function renderView()
    {
        return view('perfilMedico');
    }

    public function create(Request $request)
    {
        $request->validate([
            'especialidade_id' => "required|int",
            'data'             => "required|string",
            'hora_inicio'      => "required|string",
            'hora_fim'         => "required|string"
        ]);

        /** concatenamos a data e hora para inserir no banco, pois precisamos de dados timestamp */
        $horaInicio    = "{$request->data} {$request->hora_inicio}";
        $horaFim       = "{$request->data} {$request->hora_fim}";

        $oModelHorariosDisponiveis = $this->getModelHorariosDisponiveis();
        $oModelHorariosDisponiveis->medico_id        = auth()->user()->id;
        $oModelHorariosDisponiveis->especialidade_id = $request->especialidade_id;
        $oModelHorariosDisponiveis->inicio           = $horaInicio;
        $oModelHorariosDisponiveis->fim              = $horaFim;
        $oModelHorariosDisponiveis->data             = $request->data;

        if($oModelHorariosDisponiveis->save()){
            return response()->json([
                "message" => "horário de atendimento inserido com sucesso"
            ]);
        }

        return response()->json([
            "message" => "Erro ao registrar, tente novamente",
        ], 404);
    }

    public function update(Request $request)
    {
        $request->validate([
            'especialidade_id' => "int",
            'data'             => "string",
            'hora_inicio'      => "string",
            'hora_fim'         => "string"
        ]);

        $oModel = $this->getModelHorariosDisponiveis()->find($request->id);

        if($request->filled('data')){
            $oModel->data = $request->data;
        }

        if($request->filled('especialidade_id')){
            $oModel->especialidade_id = $request->especialidade_id;
        }       

        if($request->filled('hora_inicio')){
            if($request->filled('data')){
                $oModel->inicio = "{$request->data} {$request->hora_inicio}";
            }
        }

        if($request->filled('hora_fim')){
            if($request->filled('data')){
                $oModel->fim = "{$request->data} {$request->hora_fim}";
            }
        }

        if($oModel->save()){
            return response()->json([
                "message" => "Dados alterados com sucesso"
            ]);
        }

        return response()->json([
            "message" => "Erro ao atualizar os dados, tente novamente",
        ], 404);
    }

    public function delete(Request $request)
    {
        $request->validate([
            "id" => "required|int"
        ]);

        $oModelPersistido = $this->getModelHorariosDisponiveis()->find($request->id);

        if($oModelPersistido->delete()){
            return response()->json([
                "message" => "Registro deletado com sucesso"
            ]);
        }

        return response()->json([
            "message" => "Erro ao deletar o registro, tente novamente",
        ], 404);
    }

    /**
     * Retorna o modelo de horarios disponiveis
     * @return ModelHorariosDisponiveis
     */
    private function getModelHorariosDisponiveis(): ModelHorariosDisponiveis
    {
        $oModelHorariosDisponiveis = new ModelHorariosDisponiveis();

        return $oModelHorariosDisponiveis;
    }

    /**
     * Metodo para retorno json (ajax), onde solicita as especialidades de um médico com base em seu id de usuário
     * @param int $id
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function especialidades($id)
    {
        $medico = User::with('especialidades')->findOrFail($id);

        return response()->json(
            $medico->especialidades->map(function ($especialidade) {
                return ['id' => $especialidade->id, 'nome' => $especialidade->nome];
            })
        );
    }

}