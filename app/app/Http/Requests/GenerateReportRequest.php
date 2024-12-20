<?php

namespace App\Http\Requests;

use App\Models\Cadet;
use App\Models\ClassYear;
use Illuminate\Foundation\Http\FormRequest;

class GenerateReportRequest extends FormRequest
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
            'class_year_id' => ['required', 'integer', 
                function($value, $attribue, $fail) {
                    if(Cadet::where('class_year_id', $this->class_year_id)->active()->get()->isEmpty()) {
                        $fail('No Record found');
                    }
                }
            ],
            'semester' => ['required', 'integer'],
            'date' => ['required'],
            'admin_nco' => ['required'],
            'admin_nco_rank' => ['required'],
            'commandant' => ['required'],
            'commandant_rank' => ['required']
        ];
    }
}
