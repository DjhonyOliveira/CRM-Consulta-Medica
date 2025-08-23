<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ModelMedicoEspecialidade extends Pivot
{
    protected $table = 'medico_especialidade';
    public $timestamps = false;
    protected $primaryKey = false;

    protected $fillable = [
        'medico_id',
        'especialidade_id',
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

    /**
     * Valida se o médico logado possui a especialidade informada
     * @param int $especialidade
     * @return bool
     */
    public static function validaMedicoEspecialidade(int $especialidade): bool
    {
        $bExisteRelacionamento = self::where('medico_id', getUsuarioLogado()->id)
                                     ->where('especialidade_id', $especialidade)
                                     ->exists();

        return $bExisteRelacionamento;
    }
    
}