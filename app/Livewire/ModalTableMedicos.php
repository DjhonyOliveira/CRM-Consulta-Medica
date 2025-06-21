<?php

namespace App\Livewire;

use App\Models\User;
use App\UserTypes;
use Livewire\Component;

class ModalTableMedicos extends Component
{
    public function render()
    {
        return view('livewire.modal-table-medicos', [
            'medicos' => User::where('type_user', UserTypes::medico->value)
                            ->with('especialidades')
                            ->paginate(10)
        ]);
    }
}
