<?php

namespace App\View\Components;

abstract class ComponentBase
{
    protected string $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    /**
     * Retorna o tipo do componente
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Converte o componente em array para exportar no JSON.
     * Usa reflexão para pegar automaticamente as propriedades privadas
     */
    public function toArray(): array
    {
        $props = [];

        $reflection = new \ReflectionClass($this);
        foreach ($reflection->getProperties(\ReflectionProperty::IS_PRIVATE) as $property) {
            $name = $property->getName();
            $props[$name] = $this->{$name};
        }

        return [
            'type'  => $this->type,
            'props' => $props,
        ];
    }

    public function toJson(): string
    {
        return json_encode($this->toArray(), JSON_UNESCAPED_UNICODE);
    }
}