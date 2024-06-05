<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiagnosisController extends Controller
{
    public function findDiagnosis( string $diagnosisId)
    {
        $diagnosis = Diagnosis::findOrFail($diagnosisId);
        return response()->json($diagnosis);
    }

    public function createDiagnosis(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'appointment_id' => 'required|uuid|exists:appointments,id',
            'symptoms' => 'string',
            'notes' => 'sometimes|nullable|string',
            'prescription' => 'string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid data provided',
                'errors' => $validator->errors()
            ]);
        }
        $diagnosis = Diagnosis::create([
            'appointment_id' => $request->get('appointment_id'),
            'symptoms' => $request->get('symptoms'),
            'notes' => $request->get('notes'),
            'prescription' => $request->get('prescription')
        ]);

        return response()->json([
            'message' => 'Diagnosis added successfully',
            'id' => $diagnosis->id
        ]);
    }

    public function updateDiagnosis(Request $request, string $diagnosisId)
    {
        $validator = Validator::make($request->all(), [
            'appointment_id' => 'required|uuid|exists:appointments,id',
            'id' => 'required|uuid|exists:diagnoses,id',
            'symptoms' => 'string',
            'notes' => 'sometimes|nullable|string',
            'prescription' => 'string']);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid data provided',
                'errors' => $validator->errors()
            ]);
        }
        $diagnosis = Diagnosis::find($diagnosisId)->update([
            'symptoms' => $request->get('symptoms'),
            'notes' => $request->get('notes'),
            'prescription' => $request->get('prescription')
        ]);

        return response()->json([
            'message' => 'Diagnosis updated successfully',
            'id' => $diagnosis->id
        ]);

    }

    public function deleteDiagnosis(string $diagnosisId)
    {
        $diagnosis = (new \App\Models\Diagnosis)->delete($diagnosisId);
        return response()->json([
            'message' => 'Diagnosis deleted successfully',
        ]);
    }

}
