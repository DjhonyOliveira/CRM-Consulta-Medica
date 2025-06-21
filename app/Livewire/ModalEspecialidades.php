<?php

namespace App\Livewire;

use App\EnumAcao;
use App\Models\ModelEspecialidade;
use Livewire\Component;

class ModalEspecialidades extends Component
{
    protected $listeners = [
        "openModalFromJson" => "openModalFromJson",
    ];

    public $showModal;
    public $actionName;
    public $action;
    public $method;

    public $especialidade;

    public function render()
    {
        return view('livewire.modal-especialidades');
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
                $this->add();
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

    private function add()
    {
        $this->openModal();

        $this->actionName = 'Adicionar';
        $this->action     = EnumAcao::create->value;
        $this->method     = 'POST';
    }

    private function update($data)
    {
        $this->openModal();

        $this->action     = EnumAcao::update->value;
        $this->actionName = 'Atualizar';
        $this->method     = 'PUT';

        $this->setEspecialidadeById($data);
    }

    private function delete($data)
    {
        $this->openModal();

        $this->actionName = 'Deletar';
        $this->action     = EnumAcao::delete->value;
        $this->method     = 'delete';

        $this->setEspecialidadeById($data);
    }

    private function view($data)
    {
        $this->openModal();

        $this->action     = EnumAcao::view->value;
        $this->actionName = 'Visualizar';
        $this->method     = 'get';

        $this->setEspecialidadeById($data);
    }

    private function setEspecialidadeById($data)
    {
        $idEspecialidade = (int) $data['id'][0];

        $oModelEspecialidade = ModelEspecialidade::find($idEspecialidade);

        if(!$oModelEspecialidade){
            $this->resetaEstado();

            return;
        }

        $this->especialidade = [
            "id"   => $oModelEspecialidade->id,
            "nome" => $oModelEspecialidade->nome
        ];
    }

    private function resetaEstado()
    {
        $this->reset(['especialidade']);
    }
}
