<?php

namespace App\Livewire;

use App\Models\ModelHorariosDisponiveis;
use Carbon\Carbon;
use Livewire\Component;

class TablePerfilMedico extends Component
{

    protected $listeners = [
        "dadosAtualizados" => "render" 
    ];

    public function render()
    {
        return view('livewire.table-perfil-medico', [
            "horarios" => ModelHorariosDisponiveis::paginate(10)
                          ->where('medico_id', auth()->user()->id)
                          ->map(function($horario){
                                $horario->inicio = Carbon::parse($horario->inicio)->format('H:i');
                                $horario->fim    = Carbon::parse($horario->fim)->format('H:i');
                                $horario->data   = Carbon::parse($horario->data)->format('d/m/Y');

                                return $horario;
                            })
        ]);
    }
}