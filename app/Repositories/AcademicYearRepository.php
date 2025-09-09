<?php

namespace App\Repositories;

use App\Models\AcademicYear;
use Soft\RepositoryBase\RepositoryBase;
use App\Repositories\Interface\AcademicYearRepositoryInterface;

class AcademicYearRepository extends RepositoryBase implements AcademicYearRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new AcademicYear());
    }
}
