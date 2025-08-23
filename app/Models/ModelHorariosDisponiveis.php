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

    public function getMedicoId()
    {
        return $this->attributes['medico_id'];
    }

    public function setMedicoId(int $medicoId)
    {
        $this->attributes['medico_id'] = $medicoId;

        return $this;
    }

    public function getInicio()
    {
        return $this->attributes['inicio'];
    }

    public function setInicio(string $inicio)
    {
        $this->attributes['inicio'] = $inicio;

        return $this;
    }

    public function getFim()
    {
        return $this->attributes['fim'];
    }

    public function setFim(string $fim)
    {
        $this->attributes['fim'] = $fim;

        return $this;
    }

    public function getDisponivel()
    {
        return $this->attributes['disponivel'];
    }

    public function setDisponivel(bool $disponivel)
    {
        $this->attributes['disponivel'] = $disponivel;

        return $this;
    }

    public function getData()
    {
        return $this->attributes['data'];
    }

    public function setData(string $data)
    {
        $this->attributes['data'] = $data;

        return $this;
    }

    public function getEspecialidadeId()
    {
        return $this->attributes['especialidade_id'];
    }

    public function setEspecialidadeId(int $especialidade_id)
    {
        $this->attributes['especialidade_id'] = $especialidade_id;

        return $this;
    }

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