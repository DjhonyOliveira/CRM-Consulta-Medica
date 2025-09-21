<?php

namespace App\Enums;

enum EnumAcao: int
{
    case create = 1;
    case update = 2;
    case delete = 3;
    case view   = 4;
}
