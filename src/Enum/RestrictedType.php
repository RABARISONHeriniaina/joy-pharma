<?php

namespace App\Enum;

use App\Utils\EnumToArray;

enum RestrictedType: string
{
    use EnumToArray;

    case PRESCRIPTION = 'prescription';
    case PERMISSION = 'permission';

}
