<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class StoreChildMilestoneRequest extends FormRequest
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
            'family_member_id' => 'required|exists:family_members,id',
            'visit_id' => 'required|exists:visits,id',
            'answers' => 'required|array|min:1',
            'answers.*.milestone_lookup_id' => 'required|exists:developmental_milestone_lookups,id',
            'answers.*.is_achieved' => 'required|boolean',
            'answers.*.notes' => 'nullable|string|max:500',
        ];
    }
}
