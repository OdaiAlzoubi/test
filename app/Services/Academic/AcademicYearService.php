<?php

namespace App\Services\Academic;

use App\Repositories\Interface\AcademicYearRepositoryInterface;


class AcademicYearService
{
    public function __construct(protected AcademicYearRepositoryInterface $academicYearRepository) {}

    public function store(array $data)
    {
        return $this->academicYearRepository->create($data);
    }

    public function update(array $data, $id)
    {
        $this->academicYearRepository->findOrFail($id);
        return $this->academicYearRepository->update($data, $id);
    }

    public function delete($id)
    {
        $this->academicYearRepository->findOrFail($id);
        return $this->academicYearRepository->delete($id);
    }
}
