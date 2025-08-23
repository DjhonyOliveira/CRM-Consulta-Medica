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
        $oModelConsulta->setEspecialidadeId($request->especialidade_id);
        $oModelConsulta->setHorarioId($request->horario_id);
        $oModelConsulta->setvalor(trataValorDecimal($request->valor));

        if(!$request->filled('medico_id')){
            if($this->getUsuarioLogado()->isMedico()){
                $oModelConsulta->setMedicoId($this->getUsuarioLogado()->id);
            }
            else{
                return response()->json([
                    "message" => "É obrigatório a seleção de um médico",
                    "type"    => "error",
                ], 404);
            }
        }
        else{
            $oModelConsulta->setMedicoId($request->medico_id);
        }

        if(!$request->filled('paciente_id')){
            if($this->getUsuarioLogado()->isPaciente()){
                $oModelConsulta->setPacienteId($this->getUsuarioLogado()->id);
            }
            else{
                return response()->json([
                    "message" => "É obrigatório informar um paciente para a consulta",
                ], 404);
            }
        }
        else{
            $oModelConsulta->setPacienteId($request->paciente_id);
        }

        if($oModelConsulta->save()){
            $oModelHorariosDisponiveis = new ModelHorariosDisponiveis();
            $oModelHorariosDisponiveis->alteraStatusHorarioConsultaFromModelConsulta($oModelConsulta);

            return $this->getMensagemInsercaoOk();
        }

        return $this->getMessageInsercaoError();
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
            if($this->getUsuarioLogado()->isMedico()){
                $oModelConsulta->setMedicoId($this->getUsuarioLogado()->id);
            }
            else{
                return response()->json([
                    "message" => "É obrigatório a seleção de um médico",
                    "type"    => "error",
                ], 404);
            }
        }
        else{
            $oModelConsulta->setMedicoId($request->medico_id);
        }

        if(!$request->filled('paciente_id')){
            if($this->getUsuarioLogado()->isPaciente()){
                $oModelConsulta->setPacienteId($this->getUsuarioLogado()->id);
            }
            else{
                return response()->json([
                    "message" => "É obrigatório informar um paciente para a consulta",
                ], 404);
            }
        }
        else{
            $oModelConsulta->setPacienteId($request->paciente_id);
        }

        if($request->filled('especialidade_id')){
            $oModelConsulta->setEspecialidadeId($request->especialidade_id);
        }

        if($request->filled('horario_id')){
            $oModelConsulta->setHorarioId($request->horario_id);
        }

        if($request->filled('valor')){
            $oModelConsulta->setValor($request->valor);
        }

        if($oModelConsulta->save()){
            (new ModelHorariosDisponiveis())->alteraStatusHorarioConsultaFromModelConsulta($oModelConsulta);

            return $this->getMessageAlteracaoSucesso();
        }

        return $this->getMessageAlteracaoError();
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
                $oModelConsulta->setHorarioId($idHorarioConsultaDeletada);

                (new ModelHorariosDisponiveis())->alteraStatusHorarioConsultaFromModelConsulta($oModelConsulta, true);

                return $this->getMessageDeleteSucesso();
            }

            return $this->getMessageDeleteError();
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
     * @return mixed
     */
    public function getHorariosDisponiveisByMedico($idMedico, $idEspecialidade)
    {
        $oHorariosConsulta = ModelHorariosDisponiveis::where('medico_id', $idMedico)
            ->where('especialidade_id', $idEspecialidade)
            ->where('disponivel', true)
            ->get();

        $aHorarios = [];

        foreach($oHorariosConsulta as $horario){
            $horaInicio = formataHorarioBr($horario->inicio);
            $horaFim    = formataHorarioBr($horario->fim);
            $data       = formataDataBr($horario->data);

            $aHorarios[] = [
                'id'       => $horario->id,
                "dateTime" => "Data: {$data}, Inicio: {$horaInicio}, Fim: {$horaFim}",
            ];
        }

        return response()->json($aHorarios);
    }

}