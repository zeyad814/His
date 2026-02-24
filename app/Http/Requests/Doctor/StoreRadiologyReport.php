<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class StoreRadiologyReport extends FormRequest
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
            'radiological_request_id' => 'required|exists:radiological_requests,id|unique:radiology_reports,radiological_request_id',
            'findings_text' => 'required|string|min:10',
            'radiation_dose' => 'nullable|string|max:50',
            // 'report_file' => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:5120',
        ];
    }
}
