<?php

namespace App\Livewire\Shared;

use Livewire\Component;

class ModalButtons extends Component
{
    public array $extraButtons = [];
    public bool $permiteIncluir = true;
    public bool $permiteAlterar = true;
    public bool $permiteVisualizar = true;
    public bool $permiteDeletar = true;

    public function render()
    {
        return view('livewire.shared.modal-buttons');
    }
}