<?php

namespace App\Repositories\Interface;

use Soft\RepositoryBase\Interface\RepositoryBaseInterface;

interface StudentRepositoryInterface extends RepositoryBaseInterface
{
    public function filter($data);
    public function onlyTrashed();
    public function restore($id);
}
