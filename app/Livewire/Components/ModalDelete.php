<?php

namespace App\Livewire\Components;

use Livewire\Component;

/**
 * Classe de controle do componente modal para ação de delete do sistema
 * @package Component
 * @author Djonatan R. de Oliveira
 */
class ModalDelete extends Component
{

    protected $listeners = [
        "atualizacaoRealizada" => "resetarEstado"
    ];

    public string $nomeRotina;
    public array $dados;
    public int $action;
    public string $route;
    public bool $showModalDelete;

    public function render()
    {
        return view('livewire.components.modal-delete');
    }

    public function closeModal()
    {
        $this->showModalDelete = false;
    }

    public function resetarEstado()
    {
        $this->dados      = [];
        $this->nomeRotina = '';
        $this->closeModal();
    }

}