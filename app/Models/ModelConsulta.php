<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelConsulta extends Model
{
    use HasFactory;

    protected $table = 'consulta';

    protected $fillable = [
        'paciente_id',
        'medico_id',
        'especialidade_id',
        'horario_id',
        'valor',
        'status',
    ];

    public function getId()
    {
        return $this->attributes['id'];
    }

    public function setId(int $id)
    {
        $this->attributes['id'] = $id;

        return $this;
    }

    public function getPacienteId()
    {
        $this->attributes['paciente_id'];
    }

    public function setPacienteId(int $PacienteId)
    {
        $this->attributes['paciente_id'] = $PacienteId;

        return $this;
    }

    public function getMedicoId()
    {
        $this->attributes['medico_id'];
    }

    public function setMedicoId(int $medicoId)
    {
        $this->attributes['medico_id'] = $medicoId;

        return $this;
    }

    public function getEspecialidadeId()
    {
        $this->attributes['especialidade_id'];
    }

    public function setEspecialidadeId(int $especialidadeId)
    {
        $this->attributes['especialidade_id'] = $especialidadeId;

        return $this;
    }

    public function getHorarioId()
    {
        $this->attributes['horario_id'];
    }

    public function setHorarioId(int $horarioId)
    {
        $this->attributes['horario_id'] = $horarioId;

        return $this;
    }

    public function getValor()
    {
        $this->attributes['valor'];
    }

    public function setValor(int|float $valor)
    {
        $this->attributes['valor'] = $valor;

        return $this;
    }

    public function getStatus()
    {
        $this->attributes['status'];
    }

    public function setStatus(int $status)
    {
        $this->attributes['status'] = $status;

        return $this;
    }

    public function paciente()
    {
        return $this->belongsTo(User::class, 'paciente_id');
    }

    public function medico()
    {
        return $this->belongsTo(User::class, 'medico_id');
    }

    public function especialidade()
    {
        return $this->belongsTo(ModelEspecialidade::class);
    }

    public function horario()
    {
        return $this->belongsTo(ModelHorariosDisponiveis::class);
    }

}
