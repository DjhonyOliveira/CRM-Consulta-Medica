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

    /**
     * Valida se o médico logado possui a especialidade informada
     * @param int $especialidade
     * @return bool
     */
    public static function validaMedicoEspecialidade(int $especialidade): bool
    {
        $bExisteRelacionamento = self::where('medico_id', auth()->user()->id)
                                     ->where('especialidade_id', $especialidade)
                                     ->exists();

        return $bExisteRelacionamento;
    }
    
}