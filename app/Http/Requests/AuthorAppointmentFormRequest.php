<?php

namespace App\Http\Requests;

use App\Enums\AppointmentStatus;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class AuthorAppointmentFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required|uuid|exists:appointments,id',
            'name' => 'sometimes|nullable|string',
            'patient_id' => 'required|uuid|exists:users,id',
            'doctor_id' => 'sometimes|nullable|uuid|exists:users,id',
            'appointment_date' => 'required|date',
            'status' => [Rule::enum(AppointmentStatus::class)->only([
                AppointmentStatus::ONGOING,
                AppointmentStatus::COMPLETED,
                AppointmentStatus::CANCELLED])],
        ];
    }


  protected function failedValidation(Validator $validator)
  {
    throw new HttpResponseException(response()->json([
      'message' => 'The given data was invalid.',
      'errors' => $validator->errors(),
    ], 422));
  }
}
