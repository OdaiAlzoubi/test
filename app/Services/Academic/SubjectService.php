<?php

namespace App\Services\Academic;

use App\Repositories\Interface\SubjectRepositoryInterface;

class SubjectService
{
    public function __construct(protected SubjectRepositoryInterface $subjectRepository) {}

    public function store(array $data)
    {
        return $this->subjectRepository->create($data);
    }

    public function update(array $data, $id)
    {
        $this->subjectRepository->findOrFail($id);
        return $this->subjectRepository->update($data, $id);
    }

    public function delete($id)
    {
        $this->subjectRepository->findOrFail($id);
        return $this->subjectRepository->delete($id);
    }
}
