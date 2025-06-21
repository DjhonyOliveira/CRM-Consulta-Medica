<?php

namespace App\Livewire;

use App\EnumAcao;
use App\Models\User;
use App\UserTypes;
use Livewire\Component;

/**
 * Classe Modal para o crud de usuários
 * @author Djonatan R de Oliveira
 * @since  1.0.0
 */
class ModalUsuario extends Component
{
    protected $listeners = [
        "openModalFromJson"    => "openModalFromJson",
        "atualizacaoRealizada" => "resetarEstado"
    ];

    public $usuario = [];
    public $showModal = false;
    public $actionName;
    public $action;
    public $method;
    public $podeAlterarSenha;
    public $tipoUsuario;

    public function openModal()
    {
        $this->showModal = true;
        $this->dispatch('openModal');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->usuario   = null;
    }

    public function openModalFromJson(array $data)
    {
        $iAcao = $data['acao'];
        $this->tipoUsuario = [];

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

    public function render()
    {
        return view('livewire.modal-usuario');
    }

    public function add($data = [])
    {
        $this->tipoUsuario = UserTypes::getArrayListaTipoPessoa();

        $this->openModal();
        $this->actionName       = 'Adicionar';
        $this->method           = 'POST';
        $this->podeAlterarSenha = true;
        $this->action           = EnumAcao::create->value;
    }

    private function delete($data = [])
    {
        $this->openModal();
        $this->actionName = 'Deletar';
        $this->method     = 'DELETE';
        $this->action     = EnumAcao::delete->value;

        $this->setUsuarioById($data);
    }

    private function update($data = [])
    {
        $this->openModal();
        $this->actionName       = 'Atualizar';
        $this->method           = 'PUT';
        $this->podeAlterarSenha = User::podeAlterarSenha();
        $this->action           = EnumAcao::update->value;

        $this->setUsuarioById($data);
    }

    private function view($data = [])
    {
        $this->tipoUsuario = UserTypes::getArrayListaTipoPessoa(true);

        $this->openModal();
        $this->actionName       = 'Visualizar';
        $this->method           = 'GET';
        $this->podeAlterarSenha = false;
        $this->action           = EnumAcao::view->value;

        $this->setUsuarioById($data);
    }

    private function setUsuarioById($data)
    {
        $id = (int) $data['id'][0];

        $oModelUser = User::find($id);

        if(!$oModelUser){
            $this->resetarEstado();

            return;
        }

        $this->usuario = [
            'id'    => $oModelUser->id,
            'name'  => $oModelUser->name,
            'email' => $oModelUser->email,
            'tipo'  => $oModelUser->type_user
        ];
    }

    public function resetarEstado()
    {
        $this->reset(['usuario']);
    }

}