<?php

namespace App\Services\Academic;

use Illuminate\Support\Facades\DB;
use App\Repositories\Interface\GradeRepositoryInterface;


class GradeService
{
    public function __construct(protected GradeRepositoryInterface $gradeRepository, protected SectionService $sectionService) {}

    public function index()
    {
        $grades = $this->gradeRepository->all();
        return $grades;
    }
    public function store(array $data)
    {
        return DB::transaction(function () use ($data) {
            $grade = $this->gradeRepository->create($data);
            if (isset($data['sections'])) {
                foreach ($data['sections'] as $index => $section) {
                    $section['grade_id'] = $grade->id;
                    $this->sectionService->store($section);
                }
            }
            return $grade;
        });
    }

    public function update(array $data, $id)
    {
        return DB::transaction(function () use ($data, $id) {
            $grade = $this->gradeRepository->findOrFail($id);
            $this->gradeRepository->update($data, $id);
            if (isset($data['sections'])) {
                $this->syncSections($grade->id, $data['sections']);
            }
            return $grade;
        });
    }

    public function delete($id)
    {
        return DB::transaction(function () use ($id) {
            $this->gradeRepository->findOrFail($id);
            return $this->gradeRepository->delete($id);
        });
    }

    private function syncSections($gradeId, $sections)
    {
        foreach ($sections as $section) {
            $section['grade_id'] = $gradeId;
            if (isset($section['id'])) {
                $this->sectionService->update($section, $section['id']);
            } else {
                $this->sectionService->store($section);
            }
        }
    }
}
