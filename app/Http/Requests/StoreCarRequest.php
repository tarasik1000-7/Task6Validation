<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'license_plate' => ['required', 'string', 'max:20', 'regex:/^[A-ZА-ЯІЇЄ0-9-]+$/u', 'unique:cars,license_plate'],
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'owner_id' => 'required|exists:owners,id',
        ];
    }

    public function messages(): array
    {
        return [
            'brand.required' => 'Car brand is required.',
            'brand.string' => 'Car brand must be a string.',
            'brand.max' => 'Car brand must not exceed 100 characters.',

            'model.required' => 'Car model is required.',
            'model.string' => 'Car model must be a string.',
            'model.max' => 'Car model must not exceed 100 characters.',

            'license_plate.required' => 'License plate number is required.',
            'license_plate.string' => 'License plate number must be a string.',
            'license_plate.max' => 'License plate number must not exceed 20 characters.',
            'license_plate.regex' => 'License plate number format is invalid.',
            'license_plate.unique' => 'This license plate number already exists.',

            'year.required' => 'Car year is required.',
            'year.integer' => 'Car year must be a number.',
            'year.min' => 'Car year must be at least 1900.',
            'year.max' => 'Car year must not be greater than the current year.',

            'owner_id.required' => 'Owner is required.',
            'owner_id.exists' => 'Selected owner does not exist.',
        ];
    }
}