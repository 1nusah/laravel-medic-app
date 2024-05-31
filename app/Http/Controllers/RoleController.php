<?php

namespace App\Http\Controllers;

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
        $roles = DB::table($this->roles_table_name)->get();

        return response()->json($roles);
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
            'name' => ['required', 'min:3', 'max:30']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid data provided',
                'errors' => $validator->errors()
            ], 422);
        }

        $newRoleId = Str::uuid()->toString();
        $newRole = Role::create([
            'name' => Str::upper($request->get('name')),
            'id' => $newRoleId
        ]);
        $newRole->save();

        return response()->json([
            'message' => 'Resource created successfully',
            'id' => $newRoleId
        ]);
    }
}
