<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class StorePregnancyRequest extends FormRequest
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
            // بيانات الربط والتعريف
            'family_member_id'       => 'required|exists:family_members,id', // التأكد أن الأم مسجلة
            'pregnancy_status'       => 'required|in:current,delivered,aborted', // حالة الحمل حالياً

            // تواريخ أساسية
            'last_menstrual_period'  => 'required|date|before:today', // تاريخ أول يوم في آخر دورة
            'expected_delivery_date' => 'required|date|after:last_menstrual_period', // تاريخ الولادة المتوقع

            // التاريخ الإنجابي السابق (Obstetric History)
            'gravidity'              => 'required|integer|min:0', // عدد مرات الحمل الكلي
            'parity'                 => 'required|integer|min:0', // عدد مرات الولادة
            'abortions'              => 'required|integer|min:0', // عدد مرات الإجهاض
            'living_children'        => 'required|integer|min:0', // عدد الأطفال الأحياء
            'previous_stillbirths'   => 'required|integer|min:0', // عدد المواليد الميتين
            'previous_cesarean'      => 'required|integer|min:0', // عدد الولادات القيصرية السابقة

            // بيانات الدم والمختبر الأولية
            'blood_type'             => 'nullable|in:A,B,AB,O', // فصيلة الدم
            'rh_factor'              => 'nullable|in:Positive,Negative', // عامل ريسس
            'syphilis_test_result'   => 'nullable|string|max:50', // نتيجة اختبار الزهري

            // حالة التطعيم (التيتانوس)
            'last_tetanus_date'      => 'nullable|date|before_or_equal:today', // تاريخ آخر جرعة تيتانوس
            'tetanus_doses'          => 'nullable|integer|min:0|max:5', // عدد الجرعات السابقة
            'tetanus_immunity_status' => 'nullable|string|max:100', // محصنة / غير محصنة

            // عوامل خطر أخرى
            'consanguinity'          => 'nullable|boolean', // صلة قرابة (true/false)
        ];
    }
}
