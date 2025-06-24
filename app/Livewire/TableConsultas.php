<?php

namespace App\Livewire;

use App\Models\ModelConsulta;
use Livewire\Component;

class TableConsultas extends Component
{
    protected $listeners = [
        "dadosAtualizados" => "render" 
    ];

    public function render()
    {
        return view('livewire.table-consultas', [
            'consultas' => ModelConsulta::with(['paciente', 'medico', 'especialidade', 'horario'])->get()
        ]);
    }
}
