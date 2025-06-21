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
