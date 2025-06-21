<?php

namespace App\Http\Controllers;

use App\Models\ModelHorariosDisponiveis;
use App\Models\ModelMedicoEspecialidade;
use App\Models\ModelValorConsulta;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ControllerConsulta extends Controller
{
    public function renderView()
    {
        return view('consultas');
    }

    /**
     * Retorna o valor de consulta por médico e especialidade. (Requisição Ajax)
     * @param int $idMedico
     * @param int $idEspecialidade
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function getValorConsultaByMedicoEspecialidade($idMedico, $idEspecialidade)
    {
        $valor = ModelValorConsulta::where('medico_id', $idMedico)
            ->where('especialidade_id', $idEspecialidade)
            ->get(['valor']);

        $aValor = [];

        foreach($valor as $value){
            $aValor = [
                "valor" => "R$: {$value->valor}",
            ];
        }
        
       return response()->json($aValor);
    }

    /**
     * Retorna os horários disponiveis de consulta por médico e especialidade. (Requisição Ajax)
     * @return void
     */
    public function getHorariosDisponiveisByMedico($idMedico, $idEspecialidade)
    {
        $oHorariosConsulta = ModelHorariosDisponiveis::where('medico_id', $idMedico)
            ->where('especialidade_id', $idEspecialidade)
            ->where('disponivel', true)
            ->get();

        $aHorarios = [];

        foreach($oHorariosConsulta as $horario){
            $horaInicio = Carbon::parse($horario->inicio)->format('H:i');
            $horaFim    = Carbon::parse($horario->fim)->format('H:i');
            $data       = Carbon::parse($horario->data)->format('d/m/Y');

            $aHorarios[] = [
                'id'       => $horario->id,
                "dateTime" => "Data: {$data}, Inicio: {$horaInicio}, Fim: {$horaFim}",
            ];
        }

        return response()->json($aHorarios);
    }
}
