<?php

namespace App\View\Components;

class Input extends ComponentBase
{
    const type = "input";

    private string $inputType;
    private string $name;
    private mixed $value;
    private string $placeholder;
    private int $maxLength;
    private int $minLength;
    private bool $readOnly;
    private bool $required;

    function __construct()
    {
        parent::__construct(self::type);
    }

    /**
     * Retorna o tipo do input
     * @return string
     */ 
    public function getInputType(): string
    {
        return $this->inputType;
    }

    /**
     * Seta o tipo do input
     * @return self
     */ 
    public function setInputType(string $inputType): self
    {
        $this->inputType = $inputType;

        return $this;
    }

    /**
     * Retorna o nome do input
     * @return string
     */ 
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Seta o nome do input
     * @return self
     */ 
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Retorna o valor do input
     */ 
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * Seta o valor do input
     * @return self
     */ 
    public function setValue(mixed $value):  self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Retorna o texto do placeholder
     * @return string
     */ 
    public function getPlaceholder(): string
    {
        return $this->placeholder;
    }

    /**
     * Seta o placeholder
     * @return self
     */ 
    public function setPlaceholder(string $placeholder): self
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    /**
     * Retorna o tamanho máximo do input
     * @return int
     */ 
    public function getMaxLength(): int
    {
        return $this->maxLength;
    }

    /**
     * Seta o tamanho máximo do input
     * @return self
     */ 
    public function setMaxLength(int $maxLength): self
    {
        $this->maxLength = $maxLength;

        return $this;
    }

    /**
     * Retorna o tamanho minimo do input
     * @return int
     */ 
    public function getMinLength(): int
    {
        return $this->minLength;
    }

    /**
     * Seta o tamanho minimo do input
     * @return self
     */ 
    public function setMinLength(int $minLength): self
    {
        $this->minLength = $minLength;

        return $this;
    }

    /**
     * Retorna se o input é readOndly
     * @return bool
     */ 
    public function getReadOnly(): bool
    {
        return $this->readOnly;
    }

    /**
     * Seta se o input é readOndly
     * @return self
     */ 
    public function setReadOnly(bool $readOnly): self
    {
        $this->readOnly = $readOnly;

        return $this;
    }

    /**
     * Retorna se o input é obrigatório
     * @return bool
     */ 
    public function getRequired(): bool
    {
        return $this->required;
    }

    /**
     * Seta se o input é obrigatório
     * @return self
     */ 
    public function setRequired(bool $required): self
    {
        $this->required = $required;

        return $this;
    }
}