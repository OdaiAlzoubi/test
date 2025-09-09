<?php

namespace App\Repositories;

use App\Models\Subject;
use Soft\RepositoryBase\RepositoryBase;
use App\Repositories\Interface\SubjectRepositoryInterface;

class SubjectRepository extends RepositoryBase implements SubjectRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Subject());
    }
}
