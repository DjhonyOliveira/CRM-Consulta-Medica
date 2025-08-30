<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Input extends Component
{

    public $value;
    public bool $readOnly = false;
    public string $name;
    public string $label;


    public function render()
    {
        return view('livewire.components.input');
    }
}
