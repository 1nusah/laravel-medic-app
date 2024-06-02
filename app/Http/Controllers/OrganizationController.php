<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class OrganizationController extends Controller
{

    public function findOrganizations()
    {
        $organizations = DB::table('organizations')->get();
        return response()->json(
            $organizations
        );
    }

    public function deleteOrganization(string $id)
    {
        DB::table('organizations')->where('id', $id)->delete();
        return response()->json(['message' => 'Organization deleted successfully']);
    }

    public function fetchOrganization(string $id)
    {
        $org = DB::table('organizations')->where('id', $id)->first();

        return response()->json(
            $org
        );
    }

    public function create(Request $request)
    {
        Log::info('Validating request');
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'phoneNumber' => ['required', 'regex:/^(\+233|0|233)(20|50|24|54|55|59|25|27|57|26|56|23|28|58|53)(\d{7})$/'],
            'email' => 'required|unique:organizations|email',
            'ghanaPostAddress' => ['required', 'regex:/^([A-Z])([A-Z0-9]{1,2})-([\d]{3,5})-([\d]{3,4})$/']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The provided data was invalid',
                'errors' => $validator->errors()
            ], 422);
        }


        Log::info('Creating new organization');
        $organization = Organization::create([
            'name' => $request->get('name'),
            'phoneNumber' => $request->get('phoneNumber'),
            'email' => $request->get('email'),
            'ghanaPostAddress' => $request->get('ghanaPostAddress'),
        ]);


        return response()->json([
            'message' => 'Successfully created organization',
            'id' => $organization->id
        ]);
    }
}
