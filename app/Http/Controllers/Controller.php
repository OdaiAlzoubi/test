<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Soft\ApiResponse\Factories\ApiResponseFactory;

abstract class Controller
{
    protected function handleApi(\Closure $callback): JsonResponse
    {
        // try {
        //     return $callback();
        // } catch (ValidationException $e) {
        //     $this->logError($e);
        //     return ApiResponseFactory::error()
        //         ->message('Validation failed.')
        //         // ->errors($e->errors())
        //         ->code(422)
        //         ->toJson();
        // } catch (NotFoundHttpException $e) {
        //     $this->logError($e);
        //     return ApiResponseFactory::error()
        //         ->message('Resource not found.')
        //         ->code(404)
        //         ->toJson();
        // } catch (Throwable $e) {
        //     $this->logError($e);
        //     $message = app()->environment('production')
        //         ? 'Something went wrong. Please try again later.'
        //         : $e->getMessage();

        //     return ApiResponseFactory::error()
        //         ->message($message)
        //         ->code(500)
        //         ->toJson();
        // }
        try {
            return $callback();
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->handleException($e, 422, 'Validation failed.', $e->errors());
        } catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {
            return $this->handleException($e, 404, 'Resource not found.');
        } catch (\Illuminate\Auth\AuthenticationException $e) {
            return $this->handleException($e, 401, 'Unauthenticated.');
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return $this->handleException($e, 403, 'Forbidden.');
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->handleException($e, 500, 'Database error.');
        } catch (\DomainException $e) {
            return $this->handleException($e, 400, 'Business logic error.');
        } catch (\Exception $e) {
            return $this->handleException($e, 500, 'An unexpected error occurred.');
        } catch (\Throwable $e) {
            return $this->handleException($e, 500, 'Critical system error.');
        }
    }

    private function handleException(\Throwable $e, int $code, string $defaultMessage, $errors = null): JsonResponse
    {
        $this->logError($e);

        $message = app()->environment('production') && $code === 500
            ? 'Something went wrong. Please try again later.'
            : $e->getMessage();

        return ApiResponseFactory::error()
            ->message($defaultMessage ?: $message)
            // ->errors($errors)
            ->code($code)
            ->toJson();
    }

    private function logError(Throwable $e): void
    {
        Log::error('API Error', [
            'user_id' => auth()->id(),
            'request' => request()->all(),
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
        ]);
    }
}
