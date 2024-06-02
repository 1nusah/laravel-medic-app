<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class UserResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => Str::title($this->name),
            "email" => $this->email,
            "createdAt" => $this->created_at,
            "roles" => RoleResource::collection($this->roles),
            "organizations" => OrganizationResource::collection($this->organizations)
        ];
    }
}


