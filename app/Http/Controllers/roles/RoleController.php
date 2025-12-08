<?php

namespace App\Http\Controllers\roles;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Exception;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    //
    public function create_role(Request $request)
    {
        try {
            $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:role,name'
                ],
                'description' => [
                    'required',
                    'string',
                    'max:1000'
                ]
            ]);
            $permission = $request->input('permissions', []);
            $role = Role::create([
                'name' => $request->input('name'),
                'description' => $request->input('description')
            ]);
            if (!empty($permission)) {
                $role->permissions()->attach($permission);
            }
            return response()->json([
                'message' => 'role created successfully',
                'data' => $role
            ], 201);
        } catch (Exception $e) {
            return response(['message' => $e->getMessage(), 422]);
        }
    }

    public function getRoles()
    {
        $roles = Role::with([
            'permissions' => function ($query) {
                $query->select('permission.id', 'permission.name', 'permission.description');
            }
        ])->get();
        $roles->each(function ($role) {
            $role->permissions->each->makeHidden('pivot');
        });
        return response($roles);
    }
    public function getRole($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $role->permissions->each->makeHidden('pivot');

        return response()->json($role);
    }
    public function deleteRole($id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();
            return response([$role, 'status' => 'deleted']);
        } catch (Exception $e) {
            return response(['message' => $e->getMessage(), 404]);
        }
    }
    //name and description
    public function updateRole(Request $request, $id)
    {
        try {
            $role = role::findOrFail($id);
            $request->validate([
                'name' => 'sometimes|required|string|max:255|unique:role,name,' . $id . ',id',
                'description' => 'sometimes|nullable|string|max:500'
            ]);
            // Update only provided fields
            $role->update($request->only(['name', 'description']));
            return response($role);
        } catch (Exception $e) {
            response(['message' => $e->getMessage()]);
        }

    }
    public function attachPermissionsToRole(Request $request, $id)
    {
        try {
            $permission = $request->input('permissions', []);
            $role = Role::findOrFail($id);
            if (!empty($permission)) {
                $role->permissions()->attach($permission);
            }
            $role->load('permissions');
            return response($role);
        } catch (Exception $e) {
            return response(['message' => $e->getMessage()]);
        }
    }
    public function de_attachPermissionsToRole(Request $request, $id)
    {
        try {
            $permission = $request->input('permissions', []);
            $role = Role::findOrFail($id);
            if (!empty($permission)) {
                $role->permissions()->detach($permission);
                ;
            }
            return response($role);
        } catch (Exception $e) {
            return response(['message' => $e->getMessage()]);
        }
    }

}
