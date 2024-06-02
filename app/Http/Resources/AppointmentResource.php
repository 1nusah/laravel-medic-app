<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AppointmentResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'appointment_date' => $this->appointment_date,
            'status' => $this->status,
            'diagnoses' => $this->diagnoses,
            'doctor' => $this->doctor,
            'patient' => $this->patient
        ];
    }
}
