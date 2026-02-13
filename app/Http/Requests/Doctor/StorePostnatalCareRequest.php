<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class StorePostnatalCareRequest extends FormRequest
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
            'pregnancy_id' => 'required|exists:pregnancies,id|unique:postnatal_cares,pregnancy_id',
            'visit_date' => 'required|date',
            'delivery_type'  => 'nullable|in:natural,cesarean',
            'delivery_date' => 'nullable|date',
            'baby_status' => 'nullable|in:alive,dead,abortion',
            
            'delivery_place' => 'nullable|string|max:255',
            'attended_by' => 'nullable|string|max:255',
            'delivery_complications' => 'nullable|string',

            'first_pnc_visit_date'   => 'nullable|date',
            'first_pnc_visit_result' => 'nullable|string',
            'second_pnc_visit_date'  => 'nullable|date',
            'second_pnc_visit_result'=> 'nullable|string',
            'third_pnc_visit_date'   => 'nullable|date',
            'third_pnc_visit_result' => 'nullable|string',

            // التقييم الطبي
            'breastfeeding_type'     => 'nullable|string',
            'breastfeeding_assessment'=> 'nullable|string',
            'breastfeeding_problems'  => 'nullable|string',
            'depression_screening'   => 'nullable|string',
            'social_adjustment'      => 'nullable|string',
            'maternal_concerns'      => 'nullable|string',
            'health_education'       => 'nullable|string',

            // تنظيم الأسرة
            'contraception_method'   => 'nullable|string',
            'contraception_date'     => 'nullable|date',
            
            'additional_notes'       => 'nullable|string',
        ];
    }
}
