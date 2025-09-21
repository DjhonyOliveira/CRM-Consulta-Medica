<?php

namespace App\View\Components;

class Form extends ComponentBase
{
    const type = "form";

    private string $action;
    private string $methodForm    = "POST";
    private string $methodLaravel = "POST";
    private array $campos = [];

    function __construct()
    {
        parent::__construct(self::type);
    }

    /**
     * Retorna a action do formulário
     * @return string
     */ 
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * Seta a action do formulário
     * @return self
     */ 
    public function setAction(string $action): self
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Retorna o método do formulário (default = POST)
     * @return string
     */ 
    public function getMethodForm(): string
    {
        return $this->methodForm;
    }

    /**
     * Seta o método do formulário
     * @return self
     */ 
    public function setMethodForm(string $methodForm): self
    {
        $this->methodForm = $methodForm;

        return $this;
    }

    /**
     * Retorna o metodo de requisição do laravel
     * @return string
     */ 
    public function getMethodLaravel(): string
    {
        return $this->methodLaravel;
    }

    /**
     * Seta o metodo de requisição do laravel
     * @return self
     */ 
    public function setMethodLaravel(string $methodLaravel): self
    {
        $this->methodLaravel = $methodLaravel;

        return $this;
    }

    /**
     * Retorna os campos do formulário
     * @return array
     */ 
    public function getCampos(): array
    {
        return $this->campos;
    }

    /**
     * Seta os campos do formulário
     * @return self
     */ 
    public function setCampos(array|string $campos): self
    {
        $this->campos = $campos;

        return $this;
    }

    /**
     * Por garantia, vamos setar os campos como um json
     * @return void
     */
    public function toArray(): array
    {
        $jsonCampos = json_encode($this->getCampos());
        $this->setCampos($jsonCampos);

        return parent::toArray();
    }
}