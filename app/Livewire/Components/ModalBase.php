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

    /**
     * Retorna o titulo do mdoal
     * @return string
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Seta o titulo do modal
     * @param string $title
     * @return self
     */ 
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Retorna o method HTTP do Formulário
     * @return string
     */ 
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Seta o metodo HTTP do formulário (padrão é POST)
     * @param string $method
     * @return self
     */ 
    public function setMethod(string $method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * Retorna o action do formulário (rota destino)
     * @return string
     */ 
    public function getFormAction()
    {
        return $this->formAction;
    }

    /**
     * Seta a action do formulário
     * @param string $formAction
     * @return  self
     */ 
    public function setFormAction(string $formAction)
    {
        $this->formAction = $formAction;

        return $this;
    }

    /**
     * Retorna a ação a ser executada
     * @return int
     */ 
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Seta a ação a ser executada
     * @param int $action
     * @return self
     */ 
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Retorna se o modal esta visivel
     * @return bool
     */ 
    public function getShow()
    {
        return $this->show;
    }

    /**
     * Seta se o modal esta visivel
     * @param bool $show
     * @return self
     */ 
    public function setShow($show)
    {
        $this->show = $show;

        return $this;
    }

    /**
     * Retorna os campos do modal
     * @return array
     */ 
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Seta os campos do modal
     * @param array $fields
     * @return self
     */ 
    public function setFields(array $fields)
    {
        $this->fields = $fields;

        return $this;
    }
    
    public function render()
    {
        return view('livewire.components.modal-base', [
            "title"      => $this->getTitle(),
            "method"     => $this->getMethod(),
            "formAction" => $this->getFormAction(),
            "fields"     => $this->getFields(),
            "action"     => $this->getAction(),
            "show"       => $this->getShow()
        ])->render();
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