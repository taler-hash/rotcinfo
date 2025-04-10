<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCadetRequest extends FormRequest
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
            'id_number' => ['required', 'integer' ,'unique:cadets,id_number'],
            'name' => ['required', 'unique:cadets,name'],
            'email' => ['required', 'email', 'unique:cadets,email'],
            'gender' => ['required'],
            'age' => ['integer', 'min:15'],
            'dob' => ['required'],
            'address' => ['required'],
            'course' => ['required'],
            'religion' => ['required'],
            'b_type' => ['required'],
            'height' => ['required'],
            'beneficiary' => ['required'],
            'class_year_id' => ['required'],
            'subject' => ['required'],
            'password' => ['required'],
            'image' => ['required']
        ];
    }
}
