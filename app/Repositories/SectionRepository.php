<?php

namespace App\Repositories;

use App\Models\Section;
use Soft\RepositoryBase\RepositoryBase;
use App\Repositories\Interface\SectionRepositoryInterface;

class SectionRepository extends RepositoryBase implements SectionRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Section());
    }
}
