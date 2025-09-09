<?php

namespace App\Http\Controllers\Api\School;

use App\Http\Controllers\Controller;
use App\Services\School\GuardianService;
use Soft\ApiResponse\Factories\ApiResponseFactory;
use App\Http\Requests\Guardian\GuardianStoreRequest;
use App\Http\Requests\Guardian\GuardianUpdateRequest;

class GuardianController extends Controller
{
    public function __construct(protected GuardianService $guardianService) {}

    public function create(GuardianStoreRequest $request){
        return $this->handleApi(function () use ($request){
            $guardian = $this->guardianService->create($request->validated());
            return ApiResponseFactory::success()->data($guardian)->code(201)->toJson();
        });
    }

    public function update(GuardianUpdateRequest $request, int $student_id, int $guardian_user_id){
        return $this->handleApi(function () use ($request, $student_id, $guardian_user_id){
            $guardian = $this->guardianService->update($request->validated(), $student_id, $guardian_user_id);
            return ApiResponseFactory::success()->data($guardian)->code(200)->toJson();
        });
    }
}
