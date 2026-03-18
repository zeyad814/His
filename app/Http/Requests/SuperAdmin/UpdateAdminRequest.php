<?php

namespace App\Http\Requests\SuperAdmin;

use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
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
        $adminId = $this->route('id');
        // بنجيب اليوزر المرتبط بالأدمن ده عشان نستثني إيميله برضه
        $admin = Admin::find($adminId);
        $userId = $admin ? $admin->user?->id : null;

        return [
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $userId,
            'national_id' => 'required|string|size:14|unique:admins,national_id,' . $adminId,
            'phone' => ['required', 'string', 'unique:admins,phone,' . $adminId, 'regex:/^([0-9\s\-\+\(\)]*)$/'],
        ];
    }
}
