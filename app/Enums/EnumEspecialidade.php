<?php

namespace App\Enums;

use App\Models\ModelEspecialidade;

enum EnumEspecialidade
{
    public static function getListaEspecialidades()
    {

        $oModelEspecialidade = new ModelEspecialidade();
        $aEspecialidades     = $oModelEspecialidade->all()->toArray();

        return $aEspecialidades;
    }
}