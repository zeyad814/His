<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class StoreFamilyPlanningRequest extends FormRequest
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
            'family_member_id'   => 'required|exists:family_members,id',
            'registration_date'  => 'required|date|before_or_equal:today',
            
            // التاريخ الإنجابي
            'pregnancies_count'    => 'nullable|integer|min:0',
            'abortions_count'      => 'nullable|integer|min:0',
            'alive_children_count' => 'nullable|integer|min:0',
            'oldest_child_age'     => 'nullable|integer|min:0',
            'youngest_child_age'   => 'nullable|integer|min:0',
            'last_delivery_or_abortion_date' => 'nullable|date|before_or_equal:today',
            
            // الحالة الصحية
            'has_fever_or_discharge' => 'nullable|boolean',
            'is_breastfeeding'       => 'nullable|boolean',

            // الوسائل
            'is_using_contraception_now' => 'nullable|boolean',
            'current_method_name'        => 'nullable|string|max:255',
            'used_contraception_before'  => 'nullable|boolean',
            'previous_method_name'       => 'nullable|string|max:255',

            // الفحص
            'vaginal_scaring_or_ulcer' => 'nullable|boolean',
            'vaginal_discharge'        => 'nullable|boolean',
            'prolapse'                 => 'nullable|boolean',
            'uterus_position'          => 'nullable|in:anteverted,retroverted',
            'uterus_tenderness'        => 'nullable|boolean',
            'uterus_size'              => 'nullable|in:normal,enlarged,small',
            
            'cervix_status' => 'nullable|string',
            'conclusion'    => 'nullable|string',
        ];
    }
}
