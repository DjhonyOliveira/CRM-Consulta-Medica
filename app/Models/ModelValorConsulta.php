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

    public function medico()
    {
        return $this->belongsTo(User::class, 'medico_id');
    }

    public function especialidade()
    {
        return $this->belongsTo(ModelEspecialidade::class, 'especialidade_id');
    }
}
