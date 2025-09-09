<?php

namespace App\Services\School;

use App\Repositories\Interface\StudentRepositoryInterface;
use Illuminate\Support\Facades\DB;

class StudentService
{
    public function __construct(protected StudentRepositoryInterface $studentRepository, protected UserService $userService) {}

    public function create(array $data)
    {
        DB::beginTransaction();
        $user = $this->userService->create($data['user']);
        $data['user_id'] = $user->id;
        $student = $this->studentRepository->create($data);
        DB::commit();
        return $student;
    }

    public function index(array $data)
    {
        return $this->studentRepository->filter($data);
    }

    public function update(array $data, int $id)
    {
        DB::beginTransaction();
        $data['user_id'] = $this->studentRepository->findOrFail($id)->user->id;
        $this->userService->update($data['user'], $data['user_id']);
        return $this->studentRepository->update($data, $id);
        DB::commit();
    }

    public function find($id)
    {
        try {
            $student = $this->studentRepository->findOrFail($id);
        } catch (\Exception $e) {
            return null;
        }
        return $student;
    }

    public function show($id)
    {
        $student = $this->find($id);
        return $student;
    }

    public function delete($id)
    {
        $student = $this->studentRepository->findOrFail($id);
        $this->userService->destroy($student->user->id);
        return $this->studentRepository->delete($id);
    }

    public function onlyTrashed()
    {
        return $this->studentRepository->onlyTrashed();
    }

    public function restore($id)
    {
        $student = $this->studentRepository->onlyTrashed()->findOrFail($id);
        $this->userService->restore($student->user->id);
        $this->studentRepository->restore($id);
        return $student;
    }
}
