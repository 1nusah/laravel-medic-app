<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorOrganizationFormRequest;
use App\Http\Resources\OrganizationResource;
use App\Models\Organization;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class OrganizationController extends Controller
{

  public function findOrganizations()
  {
    $organizations = DB::table('organizations')->get();
    return OrganizationResource::collection($organizations);

  }

  public function deleteOrganization(string $id)
  {
    DB::table('organizations')->where('id', $id)->delete();
    return response()->json(['message' => 'Organization deleted successfully']);
  }

  public function fetchOrganization(string $id)
  {
    $organization = Organization::findOrFail($id);
    return OrganizationResource::make($organization);

  }

  public function create(AuthorOrganizationFormRequest $request)
  {
    $organization = Organization::create($request->validated());
    return response()->json([
      'message' => 'Successfully created organization',
      'id' => $organization->id
    ]);
  }
}
