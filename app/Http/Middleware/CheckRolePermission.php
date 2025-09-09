<?php

namespace App\Http\Middleware;

use App\Enum\RoleEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRolePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role, string $permission = null): Response
    {
        if (!auth()->check()) {
            abort(401, 'Unauthorized');
        }

        $user = auth()->user();

        if ($user->hasRole(RoleEnum::SUPERADMINISTRATOR)) {
            return $next($request);
        }

        if (!$user->hasRole($role)) {
            abort(403, 'You don\'t have the required role.');
        }

        if ($permission && !$user->can($permission)) {
            abort(403, 'You don\'t have the required permission.');
        }
        return $next($request);
    }
}
