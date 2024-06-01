<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function findUsers()
    {
        $users = User::all();
        return UserResource::collection($users);
    }

    public function findUser(string $id)
    {
        $user = User::findOrFail($id);
        return new UserResource($user);
    }


    public function deleteUser(string $id)
    {
        DB::table('users')->where('id', $id)->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }

    public function createUser(Request $request)
    {
        Log::info('Validating input');

        Log::info($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|unique:users|email',
            'password' => 'required',
            'roles' => 'required|array',
            'roles[*]' => 'exists:roles,id|distinct',
            'organizations' => 'nullable|array',
            'organizations.*' => 'distinct|exists:organizations,id',

        ]);

        if ($validator->fails()) {
            Log::info(" validation failed");
            return response()->json([
                'message' => 'Invalid data provided',
                'errors' => $validator->errors()
            ], 422);
        }

        Log::info('creating  new user');

        $userRoles = $request->get('roles');
        $userOrganizations = $request->get('organizations');
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        Log::info('created new user');
        Log::info('Attaching roles to user');
        $user->roles()->attach($userRoles);


        if ($userOrganizations) {
            Log::info('Attaching organizations to user');
            $user->organizations()->attach($userOrganizations);
        }

        return response()->json([
            'message' => 'New user created',
            'id' => $user->id,
        ]);
    }

}
