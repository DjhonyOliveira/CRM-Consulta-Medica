<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class TableMedicoEspecialidade extends Component
{

    protected $listeners = [
        "dadosAtualizados" => "render" 
    ];

    public function render()
    {
        return view('livewire.table-medico-especialidade', [
            "medico" => User::find(auth()->user()->id)->especialidades
        ]);
    }
}
