<?php

namespace App\Http\Controllers;

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
        $users = DB::table("users")->get();
        return response()->json($users);
    }

    public function findUser(string $id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        return response()->json($user);
    }


    public function deleteUser(string $id)
    {
        DB::table('users')->where('id', $id)->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }

    public function createUser(Request $request)
    {
        Log::info('Validating input');

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|unique:users|email',
            'password' => 'required',
            'role' => 'required|in:ADMIN,PATIENT,DOCTOR'
        ]);

        if ($validator->fails()) {
            Log::info(" validation failed");
            return response()->json([
                'message' => 'Invalid data provided',
                'errors' => $validator->errors()
            ], 422);
        }

        Log::info('creating  new user');

        $id = Str::uuid()->toString();
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'role' => $request->get('role'),
            'id' => $id
        ]);
        $user->save();

        return response()->json([
            'message' => 'New user created',
            'id' => $id
        ]);
    }

}
