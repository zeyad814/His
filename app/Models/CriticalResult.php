<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriticalResult extends Model
{
    use HasFactory;

    protected $fillable = [
        "test_type_and_value",
        "family_member_id",
        "visit_id",
        "result_generated_at",
        "notified_at",
        "notification_method",
        "receiving_clinic",
        "notifier_id",
        "recipient_id",
        "is_accepted",
        "doctor_action",
        "second_result_value",
        "second_result_generated_at",
        "second_notified_at",
        "second_notifier_id",
        "second_recipient_id",
        "reporting_difficulties",
        "doctor_id",
    ];

    /**
     * الطبيب المُبلغ عن النتيجة الأولى (من المعمل/الأشعة)
     */
    public function notifier()
    {
        return $this->belongsTo(Doctor::class, 'notifier_id');
    }

    /**
     * الطبيب/الممرض المستلم للبلاغ في القسم
     */
    public function recipient()
    {
        return $this->belongsTo(Doctor::class, 'recipient_id');
    }

    /**
     * الطبيب المُبلغ عن النتيجة الثانية (في حالة الرفض)
     */
    public function secondNotifier()
    {
        return $this->belongsTo(Doctor::class, 'second_notifier_id');
    }

    /**
     * الطبيب المستلم للنتيجة الثانية
     */
    public function secondRecipient()
    {
        return $this->belongsTo(Doctor::class, 'second_recipient_id');
    }

    /**
     * الطبيب المعالج الذي اتخذ الإجراء النهائي (صاحب التوقيع)
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    /**
     * الزيارة المرتبطة بها هذه النتيجة
     */
    public function visit()
    {
        return $this->belongsTo(Visit::class, 'visit_id');
    }

    /**
     * فرد العائلة الذي تم التواصل معه (إن وُجد)
     */
    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class, 'family_member_id');
    }
}
