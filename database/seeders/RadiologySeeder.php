<?php

namespace Database\Seeders;

use App\Models\RadiologicalRequest;
use App\Models\RadiologyReport;
use Illuminate\Database\Seeder;

class RadiologySeeder extends Seeder
{
    public function run(): void
    {
        // الطلب الأول: أشعة عادية
        $request1 = RadiologicalRequest::create([
            'family_member_id' => 1, // تأكد إن الـ ID ده موجود في جدول المريض
            'doctor_id' => 1, // تأكد إن الـ ID ده موجود في جدول الدكاترة
            'required_xray' => 'أشعة عادية',
            'body_part' => 'الصدر (Chest)',
            'diagnoses_reason' => 'اشتباه في التهاب رئوي وكحة مستمرة',
            'priority' => 'مستعجل',
        ]);

        RadiologyReport::create([
            'radiological_request_id' => $request1->id,
            'doctor_id' => 1,
            'findings_text' => 'Lung fields are clear. No evidence of pneumonia or pleural effusion.',
            'radiation_dose' => '0.02 mSv',
        ]);

        // الطلب الثاني: سونار
        $request2 = RadiologicalRequest::create([
            'family_member_id' => 1,
            'doctor_id' => 1,
            'required_xray' => 'سونار',
            'body_part' => 'البطن (Abdomen)',
            'diagnoses_reason' => 'آلام حادة في الجانب الأيمن العلوي',
            'priority' => 'عادي',
        ]);

        RadiologyReport::create([
            'radiological_request_id' => $request2->id,
            'doctor_id' => 1,
            'findings_text' => 'Gallbladder appears normal with no stones. Liver size is within normal limits.',
            'radiation_dose' => '0 (Ultrasound)',
        ]);
    }
}