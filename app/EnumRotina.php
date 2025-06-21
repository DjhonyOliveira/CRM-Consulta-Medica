<?php

namespace App;

enum EnumRotina: int
{
    case dashboard       = 1;
    case cadastroUsuario = 2;
    case pacientes       = 3;
    case medicos         = 4;
    case especialidades  = 5;
    case consulta        = 6;
}
