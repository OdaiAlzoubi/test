<?php

namespace App\Repositories\Interface;

use Soft\RepositoryBase\Interface\RepositoryBaseInterface;

interface GuardianRepositoryInterface extends RepositoryBaseInterface
{
    public function filter(array $data);
}
