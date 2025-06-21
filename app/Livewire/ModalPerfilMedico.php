<?php

namespace App\Livewire;

use App\EnumAcao;
use App\Models\ModelHorariosDisponiveis;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Livewire\Component;

class ModalPerfilMedico extends Component
{
    protected $listeners = [
        "openModalFromJson" => "openModalFromJson"
    ];

    public $showModal;
    public $actionName;
    public $action;
    public $method;
    public $todasEspecialidades;
    public $horario;

    public function render()
    {
        return view('livewire.modal-perfil-medico');
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
        $this->setaEspecialidadesEspecificas();
        $this->horario = [];

        $this->actionName = 'Adicionar';
        $this->action     = EnumAcao::create->value;
        $this->method     = 'POST';
    }

    private function update($data)
    {
        $this->openModal();
        $this->setaEspecialidadesEspecificas();
        $this->setHorario($data);

        $this->action     = EnumAcao::update->value;
        $this->actionName = 'Atualizar';
        $this->method     = 'PUT';
    }

    private function delete($data)
    {
        $this->openModal();
        $this->setHorario($data);

        $this->actionName = 'Deletar';
        $this->action     = EnumAcao::delete->value;
        $this->method     = 'delete';
    }

    private function view($data)
    {
        $this->openModal();
        $this->setaEspecialidadesEspecificas();
        $this->setHorario($data);

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

    private function setHorario($data)
    {
        $idHorario = $data['id'][0];

        $oModelPersistido = ModelHorariosDisponiveis::find($idHorario);

        if($oModelPersistido){
            $aDados = [
                "id"            => $oModelPersistido->id,
                "inicio"        => Carbon::parse($oModelPersistido->inicio)->format('H:i'),
                "fim"           => Carbon::parse($oModelPersistido->fim)->format('H:i'),
                "especialidade" => $oModelPersistido->especialidade_id,
                "data"          => $oModelPersistido->data,
            ];

            $this->horario = $aDados;

            return;
        }

        $this->horario = [];
    }

}