<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Enrollment\EnrollmentStoreRequest;
use App\Http\Requests\Enrollment\EnrollmentUpdateRequest;
use App\Services\Academic\EnrollmentService;
use Soft\ApiResponse\Factories\ApiResponseFactory;

class EnrollmentController extends Controller
{
    public function __construct(protected EnrollmentService $enrollmentService) {}

    public function store(EnrollmentStoreRequest $request)
    {
        return $this->handleApi(function () use ($request) {
            $enrollment = $this->enrollmentService->store($request->validated());
            return ApiResponseFactory::success()->data($enrollment)->message('Enrollment created successfully.')->code(201)->toJson();
        });
    }

    public function update(EnrollmentUpdateRequest $request, int $id)
    {
        return $this->handleApi(function () use ($request, $id) {
            $enrollment = $this->enrollmentService->update($request->validated(), $id);
            return ApiResponseFactory::success()->data($enrollment)->message('Enrollment updated successfully.')->code(200)->toJson();
        });
    }

    public function destroy(int $id)
    {
        return $this->handleApi(function () use ($id) {
            $this->enrollmentService->delete($id);
            return ApiResponseFactory::success()->message('Enrollment deleted successfully.')->code(200)->toJson();
        });
    }
}
