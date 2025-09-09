<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Services\Academic\AcademicYearService;
use Soft\ApiResponse\Factories\ApiResponseFactory;
use App\Http\Requests\AcademicYear\AcademicYearStoreRequest;
use App\Http\Requests\AcademicYear\AcademicYearUpdateRequest;

class AcademicYearController extends Controller
{
    public function __construct(protected AcademicYearService $academicYearService) {}

    public function store(AcademicYearStoreRequest $request)
    {
        return $this->handleApi(function () use ($request) {
            $academicYear = $this->academicYearService->store($request->validated());
            return ApiResponseFactory::success()->data($academicYear)->message('Academic year created successfully.')->code(201)->toJson();
        });
    }

    public function update(AcademicYearUpdateRequest $request, $id)
    {
        return $this->handleApi(function () use ($request, $id) {
            $academicYear = $this->academicYearService->update($request->validated(), $id);
            return ApiResponseFactory::success()->data($academicYear)->message('Academic year updated successfully.')->code(200)->toJson();
        });
    }

    public function destroy($id)
    {
        return $this->handleApi(function () use ($id) {
            $this->academicYearService->delete($id);
            return ApiResponseFactory::success()->message('Academic year deleted successfully.')->code(200)->toJson();
        });
    }
}
