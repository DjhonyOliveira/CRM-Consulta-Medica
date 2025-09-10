<?php

namespace App\Livewire;

use App\EnumAcao;
use App\Livewire\Components\Input;
use App\Livewire\Components\ModalBase;
use App\Models\ModelEspecialidade;
use Livewire\Component;

class ModalEspecialidades extends Component
{
    protected $listeners = [
        "openModalFromJson"    => "openModalFromJson",
        "atualizacaoRealizada" => "resetarEstado"
    ];

    public $modal;
    private array $especialidade;
    public $action;
    public $showModal = true;

    public function render()
    {
        return view('livewire.modal-especialidades', [
            "modal" => $this->getModal()
        ]);
    }

    public function getModal()
    {
        if(!isset($modal)){
            $this->modal = new ModalBase();
        }

        return $this->modal;
    }

    private function setModal(ModalBase $oModalBase)
    {
        $this->modal = $oModalBase;

        return $this;
    }

    public function openModalFromJson(array $data)
    {
        $iAcao = $data['acao'];
        $this->action = $iAcao;

        $oCampoInput = new Input();
        $oCampoInput->setLabel('Especialidade');
        $oCampoInput->setType('text');
        $oCampoInput->setName('especialidade');
        
        $oModalBase = new ModalBase();
        $oModalBase->setFormAction('especialidade.view');
        $oModalBase->setMethod('POST');
        $oModalBase->setShow(true);

        switch($iAcao){
            case EnumAcao::create->value:
                $oModalBase->setTitle('Adicionar Especialidade');
                $oModalBase->setAction($iAcao);

                break;
            case EnumAcao::update->value:
                break;
            case EnumAcao::delete->value:
                break;
            case EnumAcao::view->value:
                break;
        }

        $oModalBase->setFields([
            $oCampoInput->render()
        ]);

        $this->setModal($oModalBase);
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

    public function resetarEstado()
    {
        if($this->action != EnumAcao::create->value){
            $this->closeModal();
        }

        $this->reset(['especialidade']);
    }
}
