<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class RoleController extends Controller
{
    protected $roles_table_name = 'roles';

    public function findRoles()
    {
        $roles = Role::all();

        return RoleResource::collection($roles);
    }

    public function findRole(string $id)
    {
        $role = DB::table($this->roles_table_name)->where('id', $id)->first();

        return response()->json($role);
    }

    public function deleteRole(string $id)
    {
        $roleExists = DB::table($this->roles_table_name)->where('id', $id)->exists();
        if (!$roleExists) {
            return response()->json([
                'message' => 'Resource not found',
            ], 404);
        }


        DB::table($this->roles_table_name)->where('id', $id)->delete();
        return response()->json([
            'message' => "Resources delete"
        ]);

    }

    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'min:3', 'max:30', 'unique:roles'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid data provided',
                'errors' => $validator->errors()
            ], 422);
        }

        $newRole = Role::create([
            'name' => $request->get('name')
        ]);

        return response()->json([
            'message' => 'Resource created successfully',
            'id' => $newRole->id
        ]);
    }
}
