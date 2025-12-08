<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleCheckMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        $user = auth('api')->user();
        
        // If user not authenticated → deny
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
        
        // Get the current route name
        $routeName = $request->route()->getName();
        if (!$routeName) {
            return response()->json(['message' => 'Route has no name'], 400);
        }
        
        // Assuming user has role_id that references roles table
        $role = $user->role; // This should be a Role model instance
        
        // If role is not loaded, load it
        if (!$role || !$role instanceof Role) {
            $role = Role::with('permissions')->find($user->role_id);
            
            if (!$role) {
                return response()->json(['message' => 'User role not found'], 403);
            }
        }
        
        // Get permission names from role
        $permissionNames = $role->permissions->pluck('name')->toArray();
        
        // Check if user has permission for this route
        if (!in_array($routeName, $permissionNames)) {
            return response()->json([
                'message' => 'Forbidden: You do not have permission to access this resource',
                'required_permission' => $routeName,
                'user_permissions' => $permissionNames
            ], 403);
        }

        return $next($request);
    }
}