<?php

namespace App\Livewire;

use App\Models\User;
use App\UserTypes;
use Livewire\Component;

class ModalTablePacientes extends Component
{
    public function render()
    {
        return view('livewire.modal-table-pacientes', [
            "pacientes" => User::paginate(10)->filter(function($paciente){
                return $paciente->type_user == UserTypes::paciente->value;
            })
        ]);
    }
}
