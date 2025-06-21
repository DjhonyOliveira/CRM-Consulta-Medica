<?php

namespace App\Livewire;

use App\EnumAcao;
use App\EnumEspecialidade;
use Livewire\Component;

class ModalEspecialidadeMedico extends Component
{
    protected $listeners = [
        "openModalFromJson"    => "openModalFromJson",
        "atualizacaoRealizada" => "resetarEstado"
    ];

    public $showModal;

    public $actionName;
    public $action;
    public $method;

    public $especialidades;
    public $especialidadeSelecionada;

    public function render()
    {
        return view('livewire.modal-especialidade-medico');
    }

    public function openModal()
    {
        $this->showModal = true;
        $this->setListaEspecialidades();
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
        $this->especialidadeSelecionada = [];

        $this->actionName = "Adicionar";
        $this->method     = "POST";
        $this->action     = EnumAcao::create->value;
    }

    private function update($data)
    {
        $this->openModal();
        $this->setEspecialidadeSelecionada($data);

        $this->actionName = "Atualizar";
        $this->method     = "PUT";
        $this->action     = EnumAcao::create->value;
    }

    private function delete($data)
    {
        $this->openModal();
        $this->setEspecialidadeSelecionada($data);

        $this->actionName = "Deletar";
        $this->method     = "DELETE";
        $this->action     = EnumAcao::delete->value;
    }

    private function view($data)
    {
        $this->openModal();
        $this->setEspecialidadeSelecionada($data);

        $this->actionName = "Visualizar";
        $this->method     = "GET";
        $this->action     = EnumAcao::view->value;
    }

    private function setListaEspecialidades()
    {
        $aListaEspecialidades = EnumEspecialidade::getListaEspecialidades();

        $this->especialidades = $aListaEspecialidades;
    }

    private function setEspecialidadeSelecionada($data)
    {
        $idEspecialidade = $data['id'][0];

        if(!empty($idEspecialidade)){
            $this->especialidadeSelecionada = [
                'id' => $idEspecialidade
            ];

            return;
        }

        $this->especialidadeSelecionada = [];
    }
}
