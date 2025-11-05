<?php

namespace App\Constraints;

enum UserRole: string
{
    case ADMIN = 'ADMIN';
    case USER = 'USER';
}
