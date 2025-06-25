<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;

class ModelHorariosDisponiveis extends Model
{

    protected $table = 'horarios_disponiveis';

    protected $fillable = [
        'medico_id',
        'inicio',
        'fim',
        'disponivel',
        'data',
        'especialidade_id'
    ];

    public function medico()
    {
        return $this->belongsTo(User::class, 'medico_id');
    }

    public function especialidade()
    {
        return $this->belongsTo(ModelEspecialidade::class, 'especialidade_id');
    }

    /**
     * Altera o status de do horário de consulta do médico para disponivel = false
     * @param \App\Models\ModelConsulta $oModelConsulta
     * @return mixed
     */
    public function alteraStatusHorarioConsultaFromModelConsulta(ModelConsulta $oModelConsulta, bool $bDisponivel = false)
    {
        $oModel = $this::find($oModelConsulta->horario_id);

        $oModel->disponivel = $bDisponivel;

        try{
            $oModel->save();
        }catch(Exception $exception){
            return response()->json([
                "message" => "Erro ao agendar a consulta, tente novamente",
                "type"    => "error"
            ], 404);
        }
    }

}