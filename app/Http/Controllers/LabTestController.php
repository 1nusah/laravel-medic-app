<?php

namespace App\Http\Controllers;

use App\Models\LabTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LabTestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = LabTest::all();
        return response()->json($items);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'sometimes|nullable|string',
            'diagnosis' => 'string|required',
            'diagnosis_id' => 'exists:diagnoses,id',
            'file_key' => 'string|nullable',
            'notes' => 'string|nullable',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $lab_test = LabTest::create($validator->validated());

        return response()->json([
            'message' => 'Lab Test created successfully.',
            'id' => $lab_test->id
        ],);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $lab_test = LabTest::findOrFail($id);

        return response()->json($lab_test);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->merge('id', $id);
        $validator = Validator::make($request->all(), [
            'id' => 'exists:lab_tests,id',
            'name' => 'required|string',
            'description' => 'sometimes|nullable|string',
            'diagnosis' => 'string|required',
            'diagnosis_id' => 'exists:diagnoses,id',
            'file_key' => 'string|nullable',
            'notes' => 'string|nullable',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $lab_test = LabTest::findOrFail($id);
        $lab_test->update($validator->validated());

        return response()->json([
            'message' => 'Updated successfully',
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = LabTest::where('id', $id)->delete();
        if ($result) {
            return response()->json(['success' => 'Record has been deleted']);
        }
        return response()->json(['error' => 'Something went wrong'], 400);

    }
}
