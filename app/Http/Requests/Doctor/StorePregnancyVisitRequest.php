<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class StorePregnancyVisitRequest extends FormRequest
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
            'pregnancy_id'          => 'required|exists:pregnancies,id',
            'doctor_id'             => 'required|exists:doctors,id',
            'visit_id'         => 'required|exists:visits,id',

            //التواريخ
            'visit_date'            => 'required|date|before_or_equal:today', // تاريخ الزيارة الحالي
            'next_visit'            => 'nullable|date|after:visit_date', // موعد الزيارة القادم

            // القياسات الحيوية
            'weight'                => 'nullable|numeric|between:30,200', // الوزن بالكيلو
            'blood_pressure'        => 'nullable|string|regex:/^\d{2,3}\/\d{2,3}$/', // ضغط الدم (مثل 120/80)
            'general_exam'          => 'nullable|string|max:500', // ملاحظات الفحص العام

            // التقييم التوليدي (Obstetric Assessment)
            'fundal_height'         => 'nullable|string|max:100', // مستوى قاع الرحم (Fundal level)
            'fetal_lie'             => 'nullable|string|max:100', // وضع الجنين (Lie)
            'fetal_heart_rate'      => 'nullable|string|max:100', // نبض الجنين (Heart sound)
            'fetal_movement'        => 'nullable|string|max:100', // حركة الجنين (Movement)
            'ultrasound'            => 'nullable|string|max:500', // ملاحظات السونار (U/S)

            // التحاليل المعملية الدورية (Labs)
            'urine_analysis'        => 'nullable|string|max:200', // تحليل البول (زلال/سكر)
            'hemoglobin'            => 'nullable|numeric|between:5,18', // نسبة الهيموجلوبين
            'blood_glucose'         => 'nullable|numeric|between:40,500', // سكر الدم

            // العلاج والتثقيف
            'dental'                => 'nullable|string|max:200', // فحص الأسنان
            'vitamins'              => 'nullable|string|max:200', // الفيتامينات (حديد/كالسيوم)
            'health_education'      => 'nullable|string|max:1000', // التثقيف الصحي المقدم
            'complications'         => 'nullable|string|max:1000', // مضاعفات أو مشاكل مكتشفة
        ];
    }
}
