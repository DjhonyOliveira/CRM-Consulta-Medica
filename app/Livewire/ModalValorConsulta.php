<?php

namespace App\Livewire;

use App\Models\ModelValorConsulta;
use Livewire\Component;
use App\Models\User;
use App\EnumAcao;

class ModalValorConsulta extends Component
{
    protected $listeners = [
        "openModalFromJson"    => "openModalFromJson",
        "atualizacaoRealizada" => "resetarEstado"
    ];

    public $showModal;
    public $actionName;
    public $action;
    public $method;
    public $todasEspecialidades;
    public $valoresConsulta;

    public function render()
    {
        return view('livewire.modal-valor-consulta');
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
        $this->valoresConsulta = [];

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
        $this->setaEspecialidadesEspecificas();

        $this->actionName = 'Adicionar';
        $this->action     = EnumAcao::create->value;
        $this->method     = 'POST';
    }

    private function update($data)
    {
        $this->openModal();
        $this->setaEspecialidadesEspecificas();
        $this->setaValoresConsulta($data);

        $this->action     = EnumAcao::update->value;
        $this->actionName = 'Atualizar';
        $this->method     = 'PUT';
    }

    private function delete($data)
    {
        $this->openModal();
        $this->setaValoresConsulta($data);

        $this->actionName = 'Deletar';
        $this->action     = EnumAcao::delete->value;
        $this->method     = 'delete';
    }

    private function view($data)
    {
        $this->openModal();
        $this->setaEspecialidadesEspecificas();
        $this->setaValoresConsulta($data);

        $this->action     = EnumAcao::view->value;
        $this->actionName = 'Visualizar';
        $this->method     = 'get';
    }

    private function setaEspecialidadesEspecificas()
    {
        $medico          = User::find(auth()->user()->id)->especialidades;
        $aEspecialidades = [];

        foreach($medico as $especialidade){
            $aEspecialidades[] = [
                "id"   => $especialidade->id,
                "nome" => $especialidade->nome
            ];
        }

        if(count($aEspecialidades) > 0){
            $this->todasEspecialidades = $aEspecialidades;

            return;
        }

        $this->todasEspecialidades = [];
    }

    private function setaValoresConsulta($data)
    {
        $idValorConsulta = $data['id'][0];

        $oModelValorConsulta = ModelValorConsulta::find($idValorConsulta);

        if($oModelValorConsulta){
            $this->valoresConsulta = [
                "id"            => $oModelValorConsulta->id,
                "valor"         => $oModelValorConsulta->valor,
                "especialidade" => $oModelValorConsulta->especialidade_id,
            ];

            return;
        }

        $this->valoresConsulta = [];
    }

    public function resetarEstado()
    {
        if($this->action != EnumAcao::create->value){
            $this->closeModal();
        }
    }

}
