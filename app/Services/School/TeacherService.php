<?php

namespace App\Services\School;

use App\Services\School\UserService;


class TeacherService
{
    public function __construct(protected UserService $userService) {}

    public function create(array $data)
    {
        $user = $this->userService->create($data['user']);
        return $user;
    }

    public function update(array $data, $id)
    {
        $user = $this->userService->update($data['user'], $id);
        return $user;
    }
}
