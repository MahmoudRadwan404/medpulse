<?php

namespace App\Http\Controllers\permissions;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Models\Permission;
//use Spatie\Permission\Models\Permission; // ✅ Fixed import
class PermissionController extends Controller
{

    public function create(Request $request)
    {
        try {
            $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:permission,name'
                ],
                'description' => [
                    'required',
                    'string',
                    'max:1000'
                ]
            ]);
            //save permission
            $permission = Permission::create([
                'name' => $request->input('name'),
                'description' => $request->input('description')
            ]);
            return response()->json([
                'message' => 'Permission created successfully',
                'data' => $permission
            ], 201);

        } catch (Exception $e) {
            return response(['message' => $e->getMessage(), 422]);
        }
    }
    public function getPermissions()
    {
        try {
            $permissions = Permission::get(['id', 'name', 'description']);
            return response()->json($permissions); // ✅ Use json() for consistency
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error occurred', 
                'error' => $e->getMessage()
            ], 500); 
        }
    }
    public function getPermission($id)
    {
        $permission = Permission::findOrFail($id)->only(['id', 'name', 'description']);
        return response($permission);

    }

    public function deletePermission($id)
    {
        try {
            $permission = Permission::findOrFail($id);
            $permission->delete();
            return response([$permission, 'deleted']);
        } catch (Exception $e) {
            return response(['message' => $e->getMessage()]);
        }
    }

    public function updatePermission(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);
        try {
            $request->validate([
                'name' => 'sometimes|required|string|max:255|unique:permission,name,' . $id . ',id',
                'description' => 'sometimes|nullable|string|max:500'
            ]);
            // Update only provided fields
            $permission->update($request->only(['name', 'description']));
            return response($permission);
        } catch (Exception $e) {
            response(['message' => $e->getMessage()]);
        }

    }
}
