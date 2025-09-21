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

    public function screenClass(): string
    {
        return match($this){
            self::dashboard      => \App\View\ViewDashboard::class,
            self::usuarios       => \App\View\ViewUsuario::class,
            self::pacientes      => \App\View\ViewPacientes::class,
            self::medicos        => \App\View\ViewMedicos::class,
            self::especialidades => \App\View\ViewEspecialidades::class,
            self::consulta       => \App\View\ViewConsultas::class
        };
    }

    public static function fromCode($code): EnumRotina|null
    {
        return self::tryFrom($code);
    }
}