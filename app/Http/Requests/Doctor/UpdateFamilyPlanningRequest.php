<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFamilyPlanningRequest extends FormRequest
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
            'family_member_id'               => 'sometimes|exists:family_members,id',
            'registration_date'              => 'sometimes|date|before_or_equal:today',
            
            // التاريخ الإنجابي
            'pregnancies_count'              => 'sometimes|nullable|integer|min:0',
            'abortions_count'                => 'sometimes|nullable|integer|min:0',
            'alive_children_count'           => 'sometimes|nullable|integer|min:0',
            'oldest_child_age'               => 'sometimes|nullable|integer|min:0',
            'youngest_child_age'             => 'sometimes|nullable|integer|min:0',
            'last_delivery_or_abortion_date' => 'sometimes|nullable|date|before_or_equal:today',
            
            // الحالة الصحية
            'has_fever_or_discharge'         => 'sometimes|nullable|boolean',
            'is_breastfeeding'               => 'sometimes|nullable|boolean',

            // الوسائل
            'is_using_contraception_now'     => 'sometimes|nullable|boolean',
            'current_method_name'            => 'sometimes|nullable|string|max:255',
            'used_contraception_before'      => 'sometimes|nullable|boolean',
            'previous_method_name'           => 'sometimes|nullable|string|max:255',

            // الفحص الطبي
            'vaginal_scaring_or_ulcer'       => 'sometimes|nullable|boolean',
            'vaginal_discharge'              => 'sometimes|nullable|boolean',
            'prolapse'                       => 'sometimes|nullable|boolean',
            'uterus_position'                => 'sometimes|nullable|in:anteverted,retroverted',
            'uterus_tenderness'              => 'sometimes|nullable|boolean',
            'uterus_size'                    => 'sometimes|nullable|in:normal,enlarged,small',
            
            'cervix_status'                  => 'sometimes|nullable|string',
            'conclusion'                     => 'sometimes|nullable|string',
        ];
    }
}
