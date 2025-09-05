<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Input extends Component
{

    public $value;
    public bool $readOnly = false;
    public string $name;
    public string $label;
    public bool $required;
    public string $type;
    protected $listeners = [
        "atualizacaoRealizada" => "resetarEstado"
    ];

    /**
     * Get the value of value
     */ 
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of value
     *
     * @return  self
     */ 
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get the value of readOnly
     */ 
    public function getReadOnly()
    {
        return $this->readOnly;
    }

    /**
     * Set the value of readOnly
     *
     * @return  self
     */ 
    public function setReadOnly($readOnly)
    {
        $this->readOnly = $readOnly;

        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of label
     */ 
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set the value of label
     *
     * @return  self
     */ 
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Retorna se o Input é required ou não
     * @return bool
     */ 
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * Seta se o input é obrigatorio, padrão = true
     * @param bool $required     *
     * @return self
     */ 
    public function setRequired($required = true)
    {
        $this->required = $required;

        return $this;
    }

    /**
     * Retorna o tipo do campo
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Seta o tipo do campo
     * @param string $type
     * @return self
     */
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    public function render()
    {
        return view('livewire.components.input', [
            "label"    => $this->getLabel(),
            "readOnly" => $this->getReadOnly(),
            "value"    => $this->getValue(),
            "name"     => $this->getName(),
            "required" => $this->getRequired(),
            "type"     => $this->getType()
        ])->render();
    } 
    
    public function resetarEstado()
    {
        $this->value    = '';
        $this->readOnly = false;
        $this->name     = '';
        $this->label    = '';
        $this->required = true;
        $this->type     = '';
    }
}