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
        if(auth()->user()->isMedico()){
            return view('livewire.table-consultas', [
                'consultas' => ModelConsulta::where('medico_id', auth()->user()->id)
                                            ->with(['paciente', 'medico', 'especialidade', 'horario'])->get(),
            ]);
        }

        if(auth()->user()->isPaciente()){
            return view('livewire.table-consultas', [
                'consultas' => ModelConsulta::where('paciente_id', auth()->user()->id)
                                            ->with(['paciente', 'medico', 'especialidade', 'horario'])->get(),
            ]);
        }

        return view('livewire.table-consultas', [
            'consultas' => ModelConsulta::with(['paciente', 'medico', 'especialidade', 'horario'])->get()
        ]);
    }
}
