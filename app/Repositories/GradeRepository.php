<?php

namespace App\Repositories;

use App\Models\Grade;
use Soft\RepositoryBase\RepositoryBase;
use App\Repositories\Interface\GradeRepositoryInterface;

class GradeRepository extends RepositoryBase implements GradeRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Grade());
    }
}
