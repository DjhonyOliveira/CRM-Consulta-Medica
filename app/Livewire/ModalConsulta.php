<?php

namespace App\Livewire;

use App\EnumAcao;
use App\Models\ModelEspecialidade;
use App\Models\User;
use App\UserTypes;
use Livewire\Component;

class ModalConsulta extends Component
{

    protected $listeners = [
        "openModalFromJson"    => "openModalFromJson"
    ];

    public $showModal = false;
    public $actionName;
    public $action;
    public $method;
    public $horarios = [];
    public $pacientes = [];

    public function render()
    {
        return view('livewire.modal-consulta', [
            "medico" => User::find( auth()->user()->id)->especialidades
        ]);
    }

    public function openModal()
    {
        $this->showModal = true;
        $this->dispatch('openModal');
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function openModalFromJson(array $data)
    {
        $iAcao = $data['acao'];

        switch($iAcao){
            case EnumAcao::create->value:
                $this->add($data);
                break;
            case EnumAcao::update->value:
                $this->update($data);
                break;
            case EnumAcao::delete->value:
                $this->delete($data);
                break;
            case EnumAcao::view->value:
                $this->view($data);
                break;
        }
    }

    public function add($data = [])
    {

        $this->openModal();
        $this->actionName       = 'Adicionar';
        $this->method           = 'POST';
        $this->action           = EnumAcao::create->value;
    }

    private function delete($data = [])
    {
        $this->openModal();
        $this->actionName = 'Deletar';
        $this->method     = 'DELETE';
        $this->action     = EnumAcao::delete->value;
    }

    private function update($data = [])
    {
        $this->openModal();
        $this->actionName       = 'Atualizar';
        $this->method           = 'PUT';
        $this->action           = EnumAcao::update->value;
    }

    private function view($data = [])
    {
        $this->openModal();
        $this->actionName       = 'Visualizar';
        $this->method           = 'GET';
        $this->action           = EnumAcao::view->value;
    }
}
