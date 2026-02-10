<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePregnancyRequest extends FormRequest
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
            'family_member_id'       => 'sometimes|exists:family_members,id',
            'pregnancy_status'       => 'sometimes|string|in:current,completed,aborted',
            'last_menstrual_period'  => 'sometimes|date',
            'expected_delivery_date' => 'sometimes|date|after:last_menstrual_period',
            'gravidity'              => 'sometimes|integer|min:0',
            'parity'                 => 'sometimes|integer|min:0',
            'abortions'              => 'sometimes|integer|min:0',
            'living_children'        => 'sometimes|integer|min:0',
            'previous_stillbirths'   => 'sometimes|integer|min:0',
            'previous_cesarean'      => 'sometimes|integer|min:0',
            'blood_type'             => 'sometimes|string',
            'rh_factor'              => 'sometimes|string|in:Positive,Negative',
            'syphilis_test_result'   => 'sometimes|nullable|string',
            'last_tetanus_date'      => 'sometimes|nullable|date',
            'tetanus_doses'          => 'sometimes|integer|min:0',
            'tetanus_immunity_status'=> 'sometimes|nullable|string',
            'consanguinity'          => 'sometimes|boolean',
        ];
    }
}
