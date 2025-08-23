<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelEspecialidade extends Model
{
    protected $table = "especialidades";

    protected $fillable = [
        'nome'
    ];

    public function getId()
    {
        return $this->attributes['id'];
    }

    public function getSet(int $id)
    {
        $this->attributes['id'] = $id;

        return $this;
    }

    public function getNome()
    {
        return $this->attributes['nome'];
    }

    public function setNome(string $nome)
    {
        $this->attributes['nome'] = $nome;

        return $this;
    }

    public function medicos()
    {
        return $this->belongsToMany(User::class, 'medico_especialidade', 'medico_id', 'especialidade_id');
    }
}
