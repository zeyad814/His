<?php

namespace Database\Seeders;

use App\Models\Referral;
use App\Models\FeedbackReferral;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReferralWithFeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // استخدام Transaction لضمان تسجيل الجدولين مع بعض أو لا شيء
        DB::beginTransaction();
        try
        {
            // 1. إنشاء سجل الإحالة (Referral)
            $referral = Referral::create([
                'family_member_id' => 1,
                'doctor_id'        => 1,
                'referral_number'   => 'REF-' . now()->format('Ymd') . '-001',
                'referred_to_entity' => 'Cairo Specialized Hospital',
                'specialty'         => 'Cardiology',
                'transport_method'  => 'Ambulance',
                'reason_for_referral' => 'Patient complaining of severe chest pain and shortness of breath.',
                'urgency_type'      => 'emergency',
                'bp'                => '150/95',
                'pulse'             => 110,
                'temp'              => 37.2,
                'rr'                => 24,
                'relevant_history'  => 'Chronic hypertension for 5 years.',
                'exam_findings'     => 'Tachycardia and mild edema in lower limbs.',
                'relevant_investigations' => 'Initial ECG shows ST segment elevation.',
                'provisional_diagnosis'  => 'Suspected Acute Myocardial Infarction',
            ]);

            // 2. إنشاء رد الإحالة (Feedback) مربوط بنفس الإحالة
            FeedbackReferral::create([
                'referral_id'           => $referral->id,
                'doctor_id'             => 1,
                'arrival_at'            => now()->addHours(1),
                'specialist_findings'   => 'Confirmed MI after thorough examination and cardiac enzymes test.',
                'hospital_investigations' => 'Cardiac Catheterization, Trop-I, Echo.',
                'final_diagnosis'       => 'Acute Anterior Wall MI',
                'current_medications'   => 'Aspirin 300mg, Clopidogrel 300mg, Heparin IV.',
                'admission_ward'        => 'ICU - Bed 4',
                'surgery_type'          => 'Primary PCI (Angioplasty)',
                'other_interventions'   => 'Oxygen support and continuous cardiac monitoring.',
                'recommendations'       => 'Complete bed rest for 48 hours and follow cardiac diet.',
                'revisit_date'          => now()->addDays(14)->format('Y-m-d'),
                'sick_leave_days'       => 21,
                'follow_up_instructions' => 'Strict adherence to medications and avoid any physical stress.',
            ]);

            DB::commit();

            // رسائل التيرمنال
            $this->command->newLine();
            $this->command->info('====================================================');
            $this->command->info('✅ Medical Referral & Feedback Seeded Successfully!');
            $this->command->info('👉 Referral Number: ' . $referral->referral_number);
            $this->command->info('👉 Status: Linked with feedback record.');
            $this->command->info('====================================================');
            $this->command->newLine();

        }
        catch (\Exception $e)
        {
            DB::rollBack();
            $this->command->error('❌ Failed to seed data: ' . $e->getMessage());
        }
    }
}
