<?php

namespace App\Http\Controllers\Api\School;

use App\Http\Controllers\Controller;
use App\Services\School\TeacherService;
use App\Http\Requests\Teacher\TeacherStoreRequest;
use Soft\ApiResponse\Factories\ApiResponseFactory;
use App\Http\Requests\Teacher\TeacherUpdateRequest;

class TeacherController extends Controller
{
    public function __construct(protected TeacherService $teacherService) {}

    public function create(TeacherStoreRequest $request)
    {
        return $this->handleApi(function () use ($request) {
            $teacher = $this->teacherService->create($request->validated());
            return ApiResponseFactory::success()->data($teacher)->code(201)->toJson();
        });
    }

    public function update(TeacherUpdateRequest $request, int $id)
    {
        return $this->handleApi(function () use ($request, $id) {
            $teacher = $this->teacherService->update($request->validated(), $id);
            return ApiResponseFactory::success()->data($teacher)->code(200)->toJson();
        });
    }
}
