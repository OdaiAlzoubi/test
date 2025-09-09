<?php

namespace App\Repositories;

use App\Models\Guardian;
use Soft\RepositoryBase\RepositoryBase;
use App\Repositories\Interface\GuardianRepositoryInterface;

class GuardianRepository extends RepositoryBase implements GuardianRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Guardian());
    }

    public function filter(array $data)
    {
        $query = $this->model->query();
        return $query->get();
    }
}
