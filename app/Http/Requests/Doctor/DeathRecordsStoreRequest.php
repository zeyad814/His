<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class DeathRecordsStoreRequest extends FormRequest
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
            'death_records' => 'nullable|array',
            'death_records.*.family_member_id' => 'required|exists:family_members,id',
            'death_records.*.death_date' => 'required|date',
            'death_records.*.age_at_death' => 'required|string', 
            'death_records.*.cause_of_death' => 'required|string',
            'death_records.*.death_code' => 'nullable|string',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'family_id' => $this->route('family_id'),
        ]);
    }
}
