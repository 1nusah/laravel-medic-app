<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthorOrganizationFormRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return [
      'name' => 'required|max:255',
      'phoneNumber' => ['required', 'regex:/^(\+233|0|233)(20|50|24|54|55|59|25|27|57|26|56|23|28|58|53)(\d{7})$/'],
      'email' => 'required|unique:organizations|email',
      'ghanaPostAddress' => ['required', 'regex:/^([A-Z])([A-Z0-9]{1,2})-([\d]{3,5})-([\d]{3,4})$/']
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
