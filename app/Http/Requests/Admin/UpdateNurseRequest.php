<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateNurseRequest extends FormRequest
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
        $nurseId = $this->route('id');

        return [
            'name' => 'required|string|max:255',
            
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')
                    ->ignore($nurseId, 'userable_id')
                    ->where('userable_type', \App\Models\Nurse::class)
            ],

            'national_id' => [
                'required',
                'string',
                'size:14',
                Rule::unique('nurses', 'national_id')->ignore($nurseId)
            ],

            'phone' => 'required|string|max:20',
            'start_date' => 'required|date',
        ];
    }
}
