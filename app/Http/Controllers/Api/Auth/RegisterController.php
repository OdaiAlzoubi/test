<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Soft\ApiResponse\Factories\ApiResponseFactory;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        return $this->handleApi(function () use ($request) {
            $data = $request->validated();
            $user = User::create($data);
            $user->addRole($data['role']);
            return ApiResponseFactory::success()->data($user)->code(201)->toJson();
        });
    }
}
