<?php

namespace App\Livewire;

use App\EnumAcao;
use App\Models\ModelConsulta;
use App\Models\ModelHorariosDisponiveis;
use App\Models\User;
use Livewire\Component;

class ModalConsulta extends Component
{

    protected $listeners = [
        "openModalFromJson" => "openModalFromJson"
    ];

    public $showModal = false;
    public $actionName;
    public $action;
    public $method;
    public $horarios = [];
    public $pacientes = [];
    public $consulta;

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
        $this->consulta = [
            'id'             => '',
            'medico_id'      => '',
            'medico_nome'    => '',
            'horario_id'     => '',
            'paciente_id'    => '',
            'paciente_nome'  => '',
            'valor'          => '',
            'especialidade'  => '',
            'especialidades' => '',
        ];

        $this->openModal();
        $this->actionName       = 'Adicionar';
        $this->method           = 'POST';
        $this->action           = EnumAcao::create->value;
    }

    private function delete($data = [])
    {
        $this->getConsultaPersistida($data);

        $this->openModal();
        $this->actionName = 'Deletar';
        $this->method     = 'DELETE';
        $this->action     = EnumAcao::delete->value;
    }

    private function update($data = [])
    {
        $this->getConsultaPersistida($data);

        $this->openModal();
        $this->actionName       = 'Atualizar';
        $this->method           = 'PUT';
        $this->action           = EnumAcao::update->value;
    }

    private function view($data = [])
    {
        $this->getConsultaPersistida($data);

        $this->openModal();
        $this->actionName       = 'Visualizar';
        $this->method           = 'GET';
        $this->action           = EnumAcao::view->value;
    }

    private function getConsultaPersistida($data)
    {
        $idConsulta     = $data['id'][0];
        $oModelConsulta = ModelConsulta::find($idConsulta);

        if($oModelConsulta){
            $aConsulta = [
                'id'             => $oModelConsulta->id,
                'medico_id'      => $oModelConsulta->medico_id,
                'medico_nome'    => $oModelConsulta->medico->name,
                'horario_id'     => $oModelConsulta->horario_id,
                'paciente_id'    => $oModelConsulta->paciente_id,
                'paciente_nome'  => $oModelConsulta->paciente->name,
                'valor'          => "R$: {$oModelConsulta->valor}",
                'especialidade'  => $oModelConsulta->especialidade_id,
                'especialidades' => User::find( $oModelConsulta->medico_id)->especialidades,
                'horarios'       => ModelHorariosDisponiveis::where('medico_id', $oModelConsulta->medico_id)
                                                            ->where('especialidade_id', $oModelConsulta->especialidade_id)
                                                            ->where('disponivel', true)->get()
                                                            ->union(ModelHorariosDisponiveis::where('id', $oModelConsulta->horario_id)->get()),
            ];

            $this->consulta = $aConsulta;

            return;
        }

        $this->consulta = [
            'id'             => '',
            'medico_id'      => '',
            'medico_nome'    => '',
            'horario_id'     => '',
            'paciente_id'    => '',
            'paciente_nome'  => '',
            'valor'          => '',
            'especialidade'  => '',
            'especialidades' => '',
        ];
    }

}
