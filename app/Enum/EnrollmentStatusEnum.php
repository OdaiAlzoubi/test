<?php

namespace App\Enum;

enum EnrollmentStatusEnum :string
{
    case ACTIVE = 'active';
    case COMPLETED = 'completed';
    case WITHDRAWN = 'withdrawn';
}
