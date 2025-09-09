<?php

namespace App\Services\Academic;

use App\Repositories\Interface\SectionRepositoryInterface;



class SectionService
{
    public function __construct(protected SectionRepositoryInterface $sectionRepository) {}

    public function store(array $data)
    {
        return $this->sectionRepository->create($data);
    }

    public function update(array $data, $id)
    {
        $this->sectionRepository->findOrFail($id);
        return $this->sectionRepository->update($data, $id);
    }

    public function delete($id)
    {
        $this->sectionRepository->findOrFail($id);
        return $this->sectionRepository->delete($id);
    }
}
