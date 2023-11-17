<?php

namespace App\Enum;

use App\Utils\EnumToArray;

enum Roles: string
{
    use EnumToArray;

    case ROLE_ACL_DEFAULT = 'ROLE_USER';
    case ROLE_ACL_ALL = 'ROLE_ADMIN';
    case ROLE_CARRIER = 'ROLE_CARRIER';

}
