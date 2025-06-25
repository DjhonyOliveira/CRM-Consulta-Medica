<?php

namespace App\Http\Controllers;

use App\Models\ModelConsulta;
use App\Models\ModelHorariosDisponiveis;
use App\Models\ModelValorConsulta;
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
            (new ModelHorariosDisponiveis())->alteraStatusHorarioConsultaFromModelConsulta($oModelConsulta);

            return response()->json([
                "message" => "Consulta inserida com sucesso",
            ]);
        }

        return response()->json([
            "message" => "Erro ao cadastrar a consulta",
            "type"    => "error",
        ], 404);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id'               => "required|integer",
            'paciente_id'      => "integer",
            'medico_id'        => "integer",
            'especialidade_id' => "integer",
            'horario_id'       => "integer",
            'valor'            => "string",
        ]);

        $oModelConsulta = ModelConsulta::find($request->id);

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

        if($request->filled('especialidade_id')){
            $oModelConsulta->especialidade_id = $request->especialidade_id;
        }

        if($request->filled('horario_id')){
            $oModelConsulta->horario_id = $request->horario_id;
        }

        if($request->filled('valor')){
            $oModelConsulta->valor = $request->valor;
        }

        if($oModelConsulta->save()){
            (new ModelHorariosDisponiveis())->alteraStatusHorarioConsultaFromModelConsulta($oModelConsulta);

            return response()->json([
                "message" => "Dados Alterados com sucesso",
            ]);
        }

        return response()->json([
            "message" => "Erro ao atualizar os dados, tente novamente",
            "type"    => "error",
        ]);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => "required|integer",
        ]);

        $oModelConsulta = ModelConsulta::find($request->id);

        if($oModelConsulta){
            $idHorarioConsultaDeletada = $oModelConsulta->horario_id; 

            if($oModelConsulta->delete()){
                $oModelConsulta = new ModelConsulta();
                $oModelConsulta->horario_id = $idHorarioConsultaDeletada;

                (new ModelHorariosDisponiveis())->alteraStatusHorarioConsultaFromModelConsulta($oModelConsulta, true);

                return response()->json([
                    "message" => "Consulta deletada com sucesso"
                ]);
            }

            return response()->json([
                "message" => "não foi possivel deletar a consulta",
                "type"    => "error"
            ], 404);
        }

        return response()->json([
            "message" => "Não foi possivel localizar a consulta a ser deletada, tente novamente",
            "type"    => "error",
        ], 404);
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
        $valorLimpo   = str_replace(['', 'R$:', ' '], '', $sValor);
        $valorDecimal = str_replace(',', '.', $valorLimpo);

        return (float) $valorDecimal;
    }

}