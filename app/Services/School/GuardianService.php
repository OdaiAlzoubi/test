<?php

namespace App\Services\School;

use App\Repositories\Interface\GuardianRepositoryInterface;

class GuardianService
{
    public function __construct(protected GuardianRepositoryInterface $guardianRepository, protected UserService $userService) {}

    public function create(array $data)
    {
        $user = $this->userService->create($data['user']);
        $pivotData = [
            'relation' => $data['relation'] ?? null,
            'is_primary' => $data['is_primary'] ?? false,
        ];
        $user->guardianStudents()->attach($data['student_id'], $pivotData);
        $guardian = [
            'user' => $user,
            'student_id' => $data['student_id'],
            'relation' => $pivotData['relation'],
            'is_primary' => $pivotData['is_primary'],
        ];
        return $guardian;
    }

    public function update(array $data , $student_id, $guardian_user_id){
        $user = $this->userService->update($data['user'], $guardian_user_id);
        $pivotData = [
            'relation' => $data['relation'] ?? null,
            'is_primary' => $data['is_primary'] ?? false,
        ];
        $user->guardianStudents()->updateExistingPivot($student_id, $pivotData);
        $guardian = [
            'user' => $user,
            'student_id' => $student_id,
            'relation' => $pivotData['relation'],
            'is_primary' => $pivotData['is_primary'],
        ];
        return $guardian;
    }
}
