<?php

namespace App\Repositories;

use App\Enum\RoleEnum;
use App\Models\Student;
use App\Repositories\Interface\StudentRepositoryInterface;
use Soft\RepositoryBase\RepositoryBase;

class StudentRepository extends RepositoryBase implements StudentRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Student());
    }

    public function all()
    {
        return $this->model->query()->whereHas('user', function ($query) {
            $query->where('role', RoleEnum::STUDENT);
        })->with('user')->get();
    }

    public function filter($data)
    {
        $query = $this->model->query();
        if (isset($data['id']))
            $query->where('id', $data['id']);
        if (isset($data['student_number']))
            $query->where('student_number', $data['student_number']);
        if (isset($data['enrollment_status']))
            $query->where('enrollment_status', $data['enrollment_status']);
        if (isset($data['nationality']))
            $query->where('nationality', $data['nationality']);
        if (isset($data['current_section_id']))
            $query->where('current_section_id', $data['current_section_id']);
        if (isset($data['gender']))
            $query->whereHas('user', function ($query) use ($data) {
                $query->where('gender', $data['gender']);
            });
        if (isset($data['is_active']))
            $query->whereHas('user', function ($query) use ($data) {
                $query->where('is_active', $data['is_active']);
            });
        if (isset($data['country']))
            $query->whereHas('user', function ($query) use ($data) {
                $query->where('address->country', $data['country']);
            });
        return $query->get();
    }

    public function onlyTrashed()
    {
        return $this->model->onlyTrashed()->get();
    }

    public function restore($id)
    {
        return $this->model->onlyTrashed()->where('id', $id)->restore();
    }
}
