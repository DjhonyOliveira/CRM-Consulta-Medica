<?php

namespace App\Http\Controllers;

use App\Models\ModelConsulta;
use App\Models\ModelHorariosDisponiveis;
use App\Models\ModelValorConsulta;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ControllerConsulta extends Controller
{
    public function renderView()
    {
        return view('consultas');
    }

    public function create(Request $request)
    {
        $request->validate([
            'paciente_id'      => "integer",
            'medico_id'        => "integer",
            'especialidade_id' => "required|integer",
            'horario_id'       => "required|integer",
            'valor'            => "required|string",
        ]);

        $oModelConsulta = new ModelConsulta();
        $oModelConsulta->especialidade_id = $request->especialidade_id;
        $oModelConsulta->horario_id       = $request->horario_id;
        $oModelConsulta->valor            = $this->trataValorDecimal($request->valor);

        if(!$request->filled('medico_id')){
            if(auth()->user()->isMedico()){
                $oModelConsulta->medico_id = auth()->user()->id;
            }
            else{
                return response()->json([
                    "message" => "É obrigatório a seleção de um médico",
                    "type"    => "error",
                ], 404);
            }
        }
        else{
            $oModelConsulta->medico_id = $request->medico_id;
        }

        if(!$request->filled('paciente_id')){
            if(auth()->user()->isPaciente()){
                $oModelConsulta->paciente_id = auth()->user()->id;
            }
            else{
                return response()->json([
                    "message" => "É obrigatório informar um paciente para a consulta",
                ], 404);
            }
        }
        else{
            $oModelConsulta->paciente_id = $request->paciente_id;
        }

        if($oModelConsulta->save()){
            return response()->json([
                "message" => "Consulta inserida com sucesso",
            ]);
        }

        return response()->json([
            "message" => "Erro ao cadastrar a consulta",
            "type"    => "error",
        ], 404);
    }

    public function update()
    {

    }

    public function delete()
    {

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

    /**
     * Realiza o tratamento de um valor string para float
     * @param string $sValor
     * @return float
     */
    private function trataValorDecimal(string $sValor): float
    {
        /** Tratamos o valor para a inserção no banco */
        $valorLimpo   = str_replace(['', 'R$:', ' '], '', $sValor);
        $valorDecimal = str_replace(',', '.', $valorLimpo);

        return (float) $valorDecimal;
    }

}