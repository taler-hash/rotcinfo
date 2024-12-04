<?php

namespace App\Http\Requests;

use App\Models\ClassYear;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateClassYearRequest extends FormRequest
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
            'class' => ['required'],
            'year' => ['required'],
            'cl' => [function($attribute, $value, $fail) {
                $classYear = ClassYear::where("cl", "{$this->class}-{$this->year}")->exists();
        
                if($classYear) {
                    $fail('Class Year already existed');
                }
            }]
        ];
    }
}
