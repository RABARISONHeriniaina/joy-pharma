<?php

namespace App\Utils;

Class User
{
    public const PASSWORD_PATTERN = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/i";
    public const PASSWORD_PATTERN_MESSAGE = 'Password is required to be eight characters, at least one uppercase letter, one lowercase letter, one number and one special character (@$!%*?&).';

}