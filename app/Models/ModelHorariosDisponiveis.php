<?php

namespace App\Models;

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

}