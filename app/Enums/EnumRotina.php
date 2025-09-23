<?php

namespace App\Enums;

enum EnumRotina: int
{
    case dashboard      = 1;
    case usuarios       = 2;
    case pacientes      = 3;
    case medicos        = 4;
    case especialidades = 5;
    case consulta       = 6;


    public function label(): string
    {
        return match($this){
            self::dashboard      => "Dashboard",
            self::usuarios       => "Usuarios",      
            self::pacientes      => "Pacientes",
            self::medicos        => "Médicos",
            self::especialidades => "Especialidades",
            self::consulta       => "Consulta"
        };
    }

    /**
     * Retorna a view solicitada pelo sistema
     * @return string
     */
    public function screenClass(bool $isManutencao = false): string
    {
        if($isManutencao){
            return $this->getViewManutencao();
        }

        return $this->getViewConsulta();
    }

    /**
     * Retorna a view de consulta do sistema
     * @return string
     */
    private function getViewConsulta()
    {
        return match($this){
            self::dashboard      => \App\View\ViewConsulta\ViewConsultaDashboard::class,
            self::usuarios       => \App\View\ViewConsulta\ViewConsultaUsuario::class,
            self::pacientes      => \App\View\ViewConsulta\ViewConsultaPacientes::class,
            self::medicos        => \App\View\ViewConsulta\ViewConsultaMedicos::class,
            self::especialidades => \App\View\ViewConsulta\ViewConsultaEspecialidades::class,
            self::consulta       => \App\View\ViewConsulta\ViewConsultaConsultas::class
        };
    }

    private function getViewManutencao(): string
    {
        return '';
    }

    public static function fromCode($code): EnumRotina|null
    {
        return self::tryFrom($code);
    }
}