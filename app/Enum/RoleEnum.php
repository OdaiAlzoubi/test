<?php

namespace App\Enum;

enum RoleEnum :string
{
    case SUPERADMINISTRATOR = 'superadministrator';
    case ADMINISTRATOR = 'administrator';
    case STUDENT = 'student';
    case TEACHER = 'teacher';
    case GUARDIAN = 'guardian';
}
