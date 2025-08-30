<?php

namespace App\Livewire\Components;

use Livewire\Component;

/**
 * Classe base para a geração dos modais do sistema
 * @package View
 * @author Djonatan R. de Oliveira
 * @since 1.0.0
 */
class ModalBase extends Component
{
    public string $title;
    public string $method = 'POST';
    public string $formAction;
    public array $fields = [];
    public int $action;
    public bool $show;

    protected $listeners = [
        "atualizacaoRealizada" => "resetarEstado"
    ];
    
    public function render()
    {
        return view('livewire.components.modal-base');
    }

    public function closeModal()
    {
        $this->show = false;
    }

    public function resetarEstado()
    {
        $this->title      = '';
        $this->method     = '';
        $this->formAction = '';
        $this->fields     = [];
        $this->action     = 0;
        $this->show       = false;
    }
}