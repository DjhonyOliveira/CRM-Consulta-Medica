<?php

namespace App\Livewire;

use App\Models\ModelEspecialidade;
use Livewire\Component;

class TableEspecialidades extends Component
{
    protected $listeners = [
        "dadosAtualizados" => "render" 
    ];

    public function render()
    {
        return view('livewire.table-especialidades', [
            "especialidades" => ModelEspecialidade::paginate(10)
        ]);
    }
}
