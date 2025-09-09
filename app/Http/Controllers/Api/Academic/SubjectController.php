<?php

namespace App\Http\Controllers\Api\Academic;

use App\Http\Controllers\Controller;
use App\Http\Requests\Subject\SubjectStoreRequest;
use App\Http\Requests\Subject\SubjectUpdateRequest;
use App\Services\Academic\SubjectService;
use Soft\ApiResponse\Factories\ApiResponseFactory;

class SubjectController extends Controller
{
    public function __construct(protected SubjectService $subjectService) {}

    public function store(SubjectStoreRequest $request)
    {
        return $this->handleApi(function () use ($request) {
            $subject = $this->subjectService->store($request->validated());
            return ApiResponseFactory::success()->data($subject)->message('Subject created successfully.')->code(201)->toJson();
        });
    }

    public function update(SubjectUpdateRequest $request, $id)
    {
        return $this->handleApi(function () use ($request, $id) {
            $subject = $this->subjectService->update($request->validated(), $id);
            return ApiResponseFactory::success()->data($subject)->message('Subject updated successfully.')->code(200)->toJson();
        });
    }

    public function destroy($id)
    {
        return $this->handleApi(function () use ($id) {
            $this->subjectService->delete($id);
            return ApiResponseFactory::success()->message('Subject deleted successfully.')->code(200)->toJson();
        });
    }
}
