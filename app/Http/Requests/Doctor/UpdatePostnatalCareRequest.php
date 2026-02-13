<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostnatalCareRequest extends FormRequest
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
        'delivery_type'  => 'nullable|in:natural,cesarean',
        'delivery_date'  => 'nullable|date',
        'baby_status' => 'nullable|in:alive,dead,abortion',
        'delivery_place'  => 'nullable|string',
        'first_pnc_visit_date'  => 'nullable|date',
        'first_pnc_visit_result' => 'nullable|string',
        'second_pnc_visit_date'  => 'nullable|date',
        'second_pnc_visit_result'=> 'nullable|string',
        'third_pnc_visit_date'   => 'nullable|date',
        'third_pnc_visit_result' => 'nullable|string',
        'breastfeeding_type'  => 'nullable|string',
        'contraception_method' => 'nullable|string',
        'additional_notes'  => 'nullable|string',
        ];
    }
}
