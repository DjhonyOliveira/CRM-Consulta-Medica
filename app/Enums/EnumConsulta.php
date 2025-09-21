<?php

namespace App\Enums;

enum EnumConsulta: int
{

    case agendada  = 1;
    case realizada = 2;
    case cancelada = 3;

    public function statusConsulta(): string
    {
        return match($this){
            self::agendada  => "Agendada",
            self::realizada => "Realizada",
            self::cancelada => "Cancelada"
        };
    }

}
