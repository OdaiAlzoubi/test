<?php

namespace App\Enum;

enum SubjectTypeEnum: string
{
    case CORE = 'core';
    case ELECTIVE = 'elective';
    case OPTIONAL = 'optional';
}
