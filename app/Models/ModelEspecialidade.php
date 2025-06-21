<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelEspecialidade extends Model
{
    protected $table = "especialidades";

    protected $fillable = [
        'nome'
    ];

    public function medicos()
    {
        return $this->belongsToMany(User::class, 'medico_especialidade', 'medico_id', 'especialidade_id');
    }
}
