<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Enums\AppointmentStatus;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::all();
        return UserResource::collection($appointments);
    }


    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|nullable|string',
            'patient_id' => 'required|uuid|exists:users,id',
            'doctor_id' => 'sometimes|nullable|uuid|exists:users,id',
            'appointment_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid data provided',
                'errors' => $validator->errors()
            ], 422);
        }
        Log::info('Creating new appointment');

        $appointment = Appointment::create([
            'name' => $request->get('name'),
            'patient_id' => $request->get('patient_id'),
            'doctor_id' => $request->get('doctor_id'),
            'appointment_date' => $request->get('appointment_date'),
            'status' => $request->get('doctor_id') ? AppointmentStatus::SCHEDULED : AppointmentStatus::PENDING_ASSIGNMENT
        ]);

        return response()->json([
            'message' => 'Appointment created successfully',
            'id' => $appointment->id
        ]);

    }

    public function updateStatus(string $id)
    {

    }

    public function assignDoctor(string $id)
    {

    }
}
