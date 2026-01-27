<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class StoreSystemicExamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'physical_examination_id' => 'required|exists:physical_examinations,id',

            // كل الحقول دي مبعوتة كـ Objects في الـ JSON بتاعك، فبنخليها array
            'skin_complexion' => 'nullable|array',
            'head_neck' => 'nullable|array',
            'heart' => 'nullable|array',
            'chest' => 'nullable|array', // حولتها لـ array لأنها في الـ JSON مبعوتة كـ object
            'abdomen' => 'nullable|array',
            'neurological' => 'nullable|array', // حولتها لـ array لأنها في الـ JSON مبعوتة كـ object
            'upper_limb' => 'nullable|array', // حولتها لـ array حسب طلبك الأخير
            'lower_limb' => 'nullable|array', // حولتها لـ array حسب طلبك الأخير
            'disabilities' => 'nullable|array', // حولتها لـ array حسب طلبك الأخير

            'risk_factors' => 'nullable|array',

            // الحقل الوحيد اللي لسه مبعوث كنص عادي في الـ JSON بتاعك
            'deformities'     => 'nullable|string',
        ];
    }
}
