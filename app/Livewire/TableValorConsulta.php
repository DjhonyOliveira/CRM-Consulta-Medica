<?php

namespace App\Livewire;

use App\Models\ModelValorConsulta;
use Livewire\Component;

class TableValorConsulta extends Component
{
    protected $listeners = [
        "dadosAtualizados" => "render" 
    ];
    protected $paginationTheme = 'tailwind';

    public function render()
    {
        return view('livewire.table-valor-consulta', [
            "valorConsulta" => ModelValorConsulta::paginate(10)->where('medico_id', auth()->user()->id),
        ]);
    }
}