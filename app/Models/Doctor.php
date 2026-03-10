<?php

namespace App\Models;

use App\Models\ChronicDisease;
use App\Models\ClinicalExamination;
use App\Models\DiabetesFollowUp;
use App\Models\DrugCompatibility;
use App\Models\Family;
use App\Models\FamilyInjection;
use App\Models\FeedbackReferral;
use App\Models\GeriatricAssessmentMaster;
use App\Models\HealthUnit;
use App\Models\HypertensionFollowUp;
use App\Models\LabRequest;
use App\Models\MedicalConsent;
use App\Models\MedicalProcedure;
use App\Models\PostnatalCare;
use App\Models\PregnancyVisit;
use App\Models\PreProcedureChecklist;
use App\Models\RadiologicalRequest;
use App\Models\Referral;
use App\Models\SignificantData;
use App\Models\SurgeryUterus;
use App\Models\Visit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Doctor extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        // 'family_id',
        'health_unit_id',
        'national_id',
        // 'name',
        'phone',
        'specialization',
        'license_number',
        'start_date',
    ];

    // public function hasAnyRelatedRecords()
    // {
    //     // 1. هنجيب كل الميثودز اللي متعرفة جوه كلاس الدكتور
    //     $methods = (new \ReflectionClass($this))->getMethods(\ReflectionMethod::IS_PUBLIC);

    //     foreach ($methods as $method)
    //     {
    //         // بنفلتر الميثودز اللي مش بتاخد parameters (عشان العلاقات مش بتاخد parameters)
    //         if ($method->getNumberOfParameters() > 0) continue;

    //         try
    //         {
    //             // بنشغل الميثود ونشوف هي بترجع Object علاقة ولا لأ
    //             $return = $method->invoke($this);

    //             // لو العلاقة من نوع HasMany أو MorphMany (يعني الدكتور "صاحب" سجلات تانية)
    //             if ($return instanceof \Illuminate\Database\Eloquent\Relations\HasMany || 
    //                 $return instanceof \Illuminate\Database\Eloquent\Relations\MorphMany)
    //             {
                    
    //                 // لو لقينا سجل واحد بس في العلاقة دي، نرجع true فوراً (صدمة الأداء)
    //                 if ($return->exists())
    //                 {
    //                     return true; 
    //                 }
    //             }
    //         }
    //         catch (\Throwable $e)
    //         {
    //             continue;
    //         }
    //     }

    //     return false;
    // }

    // الدكتور كـ "طبيب أسرة" بيتابع عائلات كتير
    public function familyFollowUps()
    {
        return $this->hasMany(Family::class, 'family_doctor_id');
    }

    // الدكتور كـ "طبيب أسنان" بيتابع عائلات كتير
    public function dentistFollowUps()
    {
        return $this->hasMany(Family::class, 'dentist_id');
    }

    public function healthUnit()
    {
        return $this->belongsTo(HealthUnit::class);
    }

    public function significantData()
    {
        return $this->hasMany(SignificantData::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    public function hypertensionFollowUps()
    {
        return $this->hasMany(HypertensionFollowUp::class);
    }

    public function diabetesFollowUps()
    {
        return $this->hasMany(DiabetesFollowUp::class);
    }

    public function chronicDiseases()
    {
        return $this->hasMany(ChronicDisease::class);
    }

    public function pregnancyVisits()
    {
        return $this->hasMany(PregnancyVisit::class);
    }

    public function surgeyUterus()
    {
        return $this->hasMany(SurgeryUterus::class);
    }

    public function familyInjections()
    {
        return $this->hasMany(FamilyInjection::class);
    }



    public function geriatricAssessments()
    {
        return $this->hasMany(GeriatricAssessmentMaster::class);
    }

    public function medicalProcedures()
    {
        return $this->hasMany(MedicalProcedure::class);
    }

    public function procedureTimeOuts()
    {
        return $this->hasMany(ProcedureTimeout::class);
    }

    public function preProcedureChecklists()
    {
        return $this->hasMany(PreProcedureChecklist::class);
    }

    public function referrals()
    {
        return $this->hasMany(Referral::class);
    }

    public function feedbackReferrals()
    {
        return $this->hasMany(FeedbackReferral::class);
    }

    public function drugCompatibilities()
    {
        return $this->hasMany(DrugCompatibility::class);
    }

    public function labRequests()
    {
        return $this->hasMany(LabRequest::class);
    }

    public function medicalConsents()
    {
        return $this->hasMany(MedicalConsent::class);
    }

    public function radiologicalRequests()
    {
        return $this->hasMany(RadiologicalRequest::class);
    }

    public function radiologyReports()
    {
        return $this->hasMany(RadiologyReport::class);
    }

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function clinicalExaminations()
    {
        return $this->hasMany(ClinicalExamination::class, 'doctor_id');
    }

    public function childFollowupsAboveFive()
    {
        return $this->hasMany(ChildAboveFiveClinical::class);
    }

    public function postnatalCares()
    {
        return $this->hasMany(PostnatalCare::class, 'doctor_id');
    }

    public function obesityRecords()
    {
        return $this->hasMany(ObesityRecord::class, 'doctor_id');
    }


    public function psychologicalSupportVisits()
    {
        return $this->hasMany(PsychologicalSupportVisit::class, 'doctor_id');
    }

    public function familyPlannings()
    {
        return $this->hasMany(FamilyPlanning::class, 'doctor_id');
    }

    public function familyPlanningFollowUps()
    {
        return $this->hasMany(FamilyPlanningFollowUp::class, 'doctor_id');
    }

    public function cvRiskAssessments()
    {
        return $this->hasMany(CvRiskAssessment::class, 'doctor_id');
    }

    public function verbalOrdersOrdered()
    {
        return $this->hasMany(VerbalOrder::class, 'ordered_by_doctor_id');
    }

    public function verbalOrdersConfirmed()
    {
        return $this->hasMany(VerbalOrder::class, 'confirmed_by_doctor_id');
    }

    public function physioAssessments()
    {
        return $this->hasMany(PhysiotherapyAssessment::class, 'doctor_id');
    }

    public function premaritalScreenings()
    {
        return $this->hasMany(PremaritalScreening::class);
    }

    // النتائج الحرجة (الأولى) اللي الدكتور ده بلّغ عنها
    public function reportedCriticalResults()
    {
        return $this->hasMany(CriticalResult::class, 'notifier_id');
    }

    // النتائج الحرجة (الأولى) اللي الدكتور ده استلمها في القسم
    public function receivedCriticalResults()
    {
        return $this->hasMany(CriticalResult::class, 'recipient_id');
    }

    // النتائج الحرجة (الثانية/التأكيدية) اللي الدكتور ده بلّغ عنها
    public function reportedSecondCriticalResults()
    {
        return $this->hasMany(CriticalResult::class, 'second_notifier_id');
    }

    // النتائج الحرجة (الثانية/التأكيدية) اللي الدكتور ده استلمها
    public function receivedSecondCriticalResults()
    {
        return $this->hasMany(CriticalResult::class, 'second_recipient_id');
    }

    // الحالات اللي الدكتور ده كان هو "الطبيب المعالج" ووقع على الإجراء النهائي
    public function finalizedCriticalResults()
    {
        return $this->hasMany(CriticalResult::class, 'doctor_id');
    }
}
