<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelValorConsulta extends Model
{
    protected $table = 'valor_consulta';

    protected $fillable = [
        "medico_id",
        "especialidade_id",
        "valor"
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

    public function getMedicoId()
    {
        return $this->attributes['medico_id'];
    }

    public function setMedicoId(int $medicoId)
    {
        $this->attributes['medico_id'] = $medicoId;

        return $this;
    }

    public function getEspecialidadeId()
    {
        return $this->attributes['especialidade_id'];
    }

    public function setEspecialidadeId(int $especialidadeId)
    {
        $this->attributes['especialidade_id'] = $especialidadeId;

        return $this;
    }

    public function setValor(int|float $valor)
    {
        $this->attributes['valor'] = $valor;

        return $this;
    }

    public function getValor()
    {
        return $this->attributes['valor'];
    }

    public function medico()
    {
        return $this->belongsTo(User::class, 'medico_id');
    }

    public function especialidade()
    {
        return $this->belongsTo(ModelEspecialidade::class, 'especialidade_id');
    }

}