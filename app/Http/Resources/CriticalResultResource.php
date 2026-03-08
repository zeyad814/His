<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CriticalResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            // بيانات المريض
            'family member name' => $this->familyMember->full_name,
            
            'id' => $this->id,
            'test type and value' => $this->test_type_and_value,
            'is accepted' => $this->is_accepted,

            // بيانات الطبيب المُبلغ (Notifier)
            'notifier name' => $this->notifier->user->name,

            // بيانات الطبيب المُستلم (Recipient)
            'recipient name' => $this->recipient->user->name,

            // التوقيتات تظهر في العرض والتفاصيل
            'result generated at' => $this->result_generated_at,
            'notified at' => $this->notified_at,
            
            // بيانات تظهر فقط في صفحة الـ Show (التفاصيل الكاملة)
            'notification method' => $this->notification_method,
            'receiving clinic' => $this->receiving_clinic,
            'doctor action' => $this->doctor_action,
            
            // بيانات التبليغ الثاني (Second Notification) تظهر إذا كانت موجودة
            'second notification' => $this->second_result_value ? [
                'value' => $this->second_result_value,
                'generated at' => $this->second_result_generated_at,
                'notified at' => $this->second_notified_at,
                'notifier name' => $this->secondNotifier->user->name,
                'recipient name' => $this->secondRecipient->user->name,
                ] : null,
                
            'reporting difficulties' => $this->reporting_difficulties,
            'doctor name' => $this->doctor?->user?->name,
            'created at' => $this->created_at,
        ];
    }
}
