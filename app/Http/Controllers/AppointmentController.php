<?php

namespace App\Http\Controllers;

use App\Http\Resources\AppointmentResource;
use App\Http\Resources\UserResource;
use App\Models\Appointment;
use App\Models\Diagnosis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Enums\AppointmentStatus;
use Illuminate\Validation\Rule;

class AppointmentController extends Controller
{
    public function findAppointments()
    {
        $appointments = Appointment::all();
        return AppointmentResource::collection($appointments);
    }

    public function getAppointmentDetails(string $appointmentId)
    {
        $appointment = Appointment::findOrFail($appointmentId)
            ->load('patient')
            ->load('doctor')
            ->load('diagnoses');
        return response()->json([
            'data' => $appointment
        ]);
    }

    public function updateAppointmentDetails(Request $request, string $appointmentId)
    {
        $request->merge(['id', $appointmentId]);
        $validator = Validator::make($request->all(), [
            'id' => 'required|uuid|exists:appointments,id',
            'name' => 'sometimes|nullable|string',
            'patient_id' => 'required|uuid|exists:users,id',
            'doctor_id' => 'sometimes|nullable|uuid|exists:users,id',
            'appointment_date' => 'required|date',
            'status' => [Rule::enum(AppointmentStatus::class)->only([
                AppointmentStatus::ONGOING,
                AppointmentStatus::COMPLETED,
                AppointmentStatus::CANCELLED])],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid data provided',
                'errors' => $validator->errors()
            ], 422);
        };

        Appointment::where('id', $appointmentId)->update(
            $request->only(['name', 'patient_id', 'doctor_id', 'appointment_date', 'status']));

        return response()->json([
            'message' => 'Appointment updated successfully'
        ]);

    }

    public function createNewAppointment(Request $request)
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


    public function assignDoctor(Request $request, string $appointmentId)
    {

        $request->merge(['id' => $appointmentId]);
        $validator = Validator::make($request->all(), [
            'doctor_id' => 'required|uuid|exists:users,id',
            'id' => 'required|uuid|exists:appointments,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid data provided',
                'errors' => $validator->errors()
            ], 422);
        }

        Appointment::where('id', $appointmentId)->update([
            'doctor_id' => $request->get('doctor_id'),
            'status' => AppointmentStatus::SCHEDULED
        ]);

        return response()->json([
            'message' => 'Doctor assigned successfully',
        ]);

    }


    public function updateAppointmentStatus(Request $request, string $appointmentId)
    {
        $request->merge(['id' => $appointmentId]);
        $validator = Validator::make($request->all(), [
            'status' => [Rule::enum(AppointmentStatus::class)->only([
                AppointmentStatus::ONGOING,
                AppointmentStatus::COMPLETED,
                AppointmentStatus::CANCELLED])],
            'id' => 'required|uuid|exists:appointments,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid data provided',
                'errors' => $validator->errors()
            ], 422);
        };

        Appointment::where('id', $appointmentId)->update([
            'status' => $request->get('status')

        ]);

        return response()->json([
            'message' => 'Appointment status updated successfully',
        ]);
    }


}
