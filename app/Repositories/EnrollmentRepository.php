<?php

namespace App\Repositories;

use App\Models\Enrollment;
use Soft\RepositoryBase\RepositoryBase;
use App\Repositories\Interface\EnrollmentRepositoryInterface;

class EnrollmentRepository extends RepositoryBase implements EnrollmentRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Enrollment());
    }
}
