<?php

namespace App\Enums;

enum EnumAcao: int
{
    case create = 1;
    case update = 2;
    case delete = 3;
    case view   = 4;
    case index  = 5;

    /**
     * Valida se a ação atual é referente a manutenção da rotina (insert, update, delete, view)
     * @param int $acao
     * @return bool
     */
    public static function isManutencao(int $acao): bool
    {
        return $acao !== self::index->value;
    }
}
