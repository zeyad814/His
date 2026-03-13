<?php

use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\NurseController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Doctor\BirthScreeningController;
use App\Http\Controllers\Doctor\ChildAboveFiveClinicalController;
use App\Http\Controllers\Doctor\ChildAboveFiveVitalController;
use App\Http\Controllers\Doctor\ChildGrowthController;
use App\Http\Controllers\Doctor\ChildMilestoneController;
use App\Http\Controllers\Doctor\ChronicDiseaseController;
use App\Http\Controllers\Doctor\ChronicDiseaseVisitController;
use App\Http\Controllers\Doctor\ClinicalExaminationController;
use App\Http\Controllers\Doctor\CriticalResultController;
use App\Http\Controllers\Doctor\CvRiskAssessmentController;
use App\Http\Controllers\Doctor\DentalExaminationController;
use App\Http\Controllers\Doctor\DiabetesFollowUpController;
use App\Http\Controllers\Doctor\FamilyController;
use App\Http\Controllers\Doctor\FamilyInjectionController;
use App\Http\Controllers\Doctor\FamilyPlanningController;
use App\Http\Controllers\Doctor\FamilyPlanningFollowUpController;
use App\Http\Controllers\Doctor\FeedbackReferralController;
use App\Http\Controllers\Doctor\GeneralExaminationController;
use App\Http\Controllers\Doctor\HypertensionStepController;
use App\Http\Controllers\Doctor\ObesityRecordController;
use App\Http\Controllers\Doctor\PhysiotherapyAssessmentController;
use App\Http\Controllers\Doctor\PostnatalCareController;
use App\Http\Controllers\Doctor\PregnancyController;
use App\Http\Controllers\Doctor\PregnancyVisitController;
use App\Http\Controllers\Doctor\PremaritalScreeningController;
use App\Http\Controllers\Doctor\PsychologicalSupportVisitController;
use App\Http\Controllers\Doctor\RadiologicalRequestController;
use App\Http\Controllers\Doctor\RadiologyReportController;
use App\Http\Controllers\Doctor\ReferralController;
use App\Http\Controllers\Doctor\SignificantDataController;
use App\Http\Controllers\Doctor\SurgeryUterusController;
use App\Http\Controllers\Doctor\VerbalOrderController;
use App\Http\Controllers\Doctor\VisitController;
use App\Http\Controllers\OutpatientNursingAssessmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [LoginController::class, 'login']);
 Route::apiResource('outpatient-nursing-assessments', OutpatientNursingAssessmentController::class);

// Doctor
Route::middleware('auth:sanctum')->group(function () {

 Route::apiResource('outpatient-nursing-assessments', OutpatientNursingAssessmentController::class);

    // Doctor
    Route::middleware('doctor')->group(function () {
        // Family
        Route::get('/families', [FamilyController::class, 'index']);
        Route::post('/family/store', [FamilyController::class, 'store']);
        Route::post('/family/store/member/{family_id}', [FamilyController::class, 'storeMembers']);
        Route::patch('/family/assign/doctor/{family_id}', [FamilyController::class, 'assignDoctors']);
        Route::post('/family/store/medical/history/{family_id}', [FamilyController::class, 'storeMedicalHistory']);
        Route::post('/family/store/death/record/{family_id}', [FamilyController::class, 'storeDeathRecords']);
        Route::post('/family/store/housing/info/{family_id}', [FamilyController::class, 'storeHousingInfo']);
        Route::post('/family/store/social/research/{family_id}', [FamilyController::class, 'storeSocialResearch']);
        Route::get('/families/show/{family_id}', [FamilyController::class, 'show']);
        Route::get('/family/edit/{family_id}', [FamilyController::class, 'edit']);
        Route::put('/family/update/{family_id}', [FamilyController::class, 'update']);
        Route::get('/family/edit/members/{family_id}', [FamilyController::class, 'editMembers']);
        Route::put('/family/update/members/{family_id}', [FamilyController::class, 'updateMembers']);
        Route::get('/family/assign/doctor/edit/{family_id}', [FamilyController::class, 'editAssignDoctors']);
        Route::get('/family/medical-history/edit/{family_id}', [FamilyController::class, 'editMedicalHistory']);
        Route::put('/family/medical-history/update/{family_id}', [FamilyController::class, 'updateMedicalHistory']);
        Route::get('/family/death-records/edit/{family_id}', [FamilyController::class, 'editDeathRecords']);
        Route::get('/family/housing-info/edit/{family_id}', [FamilyController::class, 'editHousingInfo']);
        Route::get('/family/social-research/edit/{family_id}', [FamilyController::class, 'editSocialResearch']);

       
        // Doctor Examination
        Route::prefix('doctor')->group(function () {
            // General Examination
            Route::post('/physical-examination/history', [GeneralExaminationController::class, 'store']);
            Route::post('/general-examination/vitals', [GeneralExaminationController::class, 'storeVitals']);
            Route::patch('/general-examination/systemic-exam', [GeneralExaminationController::class, 'storeSystemicExamination']);
            Route::patch('/general-examination/final-exam', [GeneralExaminationController::class, 'storeFinalAssessment']);
            Route::get('/family-members/{family_member_id}/full-examination', [GeneralExaminationController::class, 'show']);
            Route::get('/physical-examination/edit/{family_member_id}', [GeneralExaminationController::class, 'edit']);
            Route::get('/general-examination/vitals/edit/{physical_examination_id}', [GeneralExaminationController::class, 'editVitals']);
            Route::get('/general-examination/systemic-exam/edit/{physical_examination_id}', [GeneralExaminationController::class, 'editSystemic']);
            Route::get('/general-examination/final-exam/edit/{physical_examination_id}', [GeneralExaminationController::class, 'editFinalAssessment']);

            // Significant Data
            Route::get('/family-member/{family_member_id}/significant-data/index', [SignificantDataController::class, 'index']);
            Route::post('/family-member/{family_member_id}/significant-data/store', [SignificantDataController::class, 'store']);
            Route::get('/family-member/significant-data/edit/{id}', [SignificantDataController::class, 'edit']);
            Route::put('/family-member/significant-data/update/{id}', [SignificantDataController::class, 'update']);
            Route::delete('/family-member/significant-data/{id}', [SignificantDataController::class, 'destroy']);

            // Hypertension Follow Up
            Route::prefix('/hypertension')->group(function () {
                Route::post('/store/step-1', [HypertensionStepController::class, 'storeStep1']);
                Route::patch('/store/step-2', [HypertensionStepController::class, 'storeStep2']);
                Route::patch('/store/step-3', [HypertensionStepController::class, 'storeStep3']);
                Route::patch('/store/step-4', [HypertensionStepController::class, 'storeStep4']);
                Route::get('/{id}/show', [HypertensionStepController::class, 'show']);
                Route::get('/edit-step-1/{id}', [HypertensionStepController::class, 'editStep1']);
                Route::patch('/update-step-1/{id}', [HypertensionStepController::class, 'updateStep1']);
                Route::get('/edit-step-2/{id}', [HypertensionStepController::class, 'editStep2']);
                Route::get('/edit-step-3/{id}', [HypertensionStepController::class, 'editStep3']);
                Route::get('/edit-step-4/{id}', [HypertensionStepController::class, 'editStep4']);
                Route::delete('/{id}/delete', [HypertensionStepController::class, 'destroy']);
            });

            // Diabetes Follow Up
            Route::prefix('/diabetes-follow-up')->group(function () {
                Route::post('/store/step-1', [DiabetesFollowUpController::class, 'storeStep1']);
                Route::patch('/store/step-2', [DiabetesFollowUpController::class, 'storeStep2']);
                Route::patch('/store/step-3', [DiabetesFollowUpController::class, 'storeStep3']);
                Route::patch('/store/step-4', [DiabetesFollowUpController::class, 'storeStep4']);
                Route::get('/{id}/show', [DiabetesFollowUpController::class, 'show']);
                Route::get('/edit-step-1/{id}', [DiabetesFollowUpController::class, 'editStep1']);
                Route::patch('/update-step-1/{id}', [DiabetesFollowUpController::class, 'updateStep1']);
                Route::get('/edit-step-2/{id}', [DiabetesFollowUpController::class, 'editStep2']);
                Route::get('/edit-step-3/{id}', [DiabetesFollowUpController::class, 'editStep3']);
                Route::get('/edit-step-4/{id}', [DiabetesFollowUpController::class, 'editStep4']);
                Route::delete('/{id}/delete', [DiabetesFollowUpController::class, 'destroy']);
            });

            // Birth Screening
            Route::prefix('/birth-screening')->group(function () {
                Route::post("/store", [BirthScreeningController::class, "store"]);
                Route::get("/edit/{family_member_id}", [BirthScreeningController::class, "edit"]);
                Route::patch("/store-special-cases", [BirthScreeningController::class, "storeSpecialCases"]);
                Route::get("/edit-special-cases/{family_member_id}", [BirthScreeningController::class, "editSpecialCases"]);
                Route::get('/show/{family_member_id}', [BirthScreeningController::class, 'show']);
            });

            // Growth Visit
            Route::prefix('/growth-visit')->group(function () {
                Route::post('/store', [BirthScreeningController::class, 'storeGrowthVisit']);
                Route::get('/edit/{id}', [BirthScreeningController::class, 'editGrowthVisit']);
                Route::put('/update/{id}', [BirthScreeningController::class, 'updateGrowthVisit']);
            });

            // Clinical Examination
            Route::prefix('/clinical-examination')->group(function () {
                Route::get('/{family_member_id}', [ClinicalExaminationController::class, 'index']);
                Route::post('/store', [ClinicalExaminationController::class, 'store']);
                Route::get('/edit/{id}', [ClinicalExaminationController::class, 'edit']);
                Route::put('/update/{id}', [ClinicalExaminationController::class, 'update']);
                Route::delete('/delete/{id}', [ClinicalExaminationController::class, 'destroy']);
            });

            // Child Milestones
            Route::prefix('/child-milestones')->group(function () {
                Route::get('/stages', [ChildMilestoneController::class, 'getMilestoneStages']);
                Route::get('/questions', [ChildMilestoneController::class, 'getQuestionsByStage']);
                Route::post('/store', [ChildMilestoneController::class, 'store']);
                Route::get('/show/{family_member_id}', [ChildMilestoneController::class, 'show']);
                Route::get('/edit/{family_member_id}', [ChildMilestoneController::class, 'edit']);
            });

            // Child Growth
            Route::prefix('/child-growth')->group(function () {
                Route::post('/store', [ChildGrowthController::class, 'store']);
                Route::get('/edit/{visit_id}', [ChildGrowthController::class, 'edit']);
                Route::get('/history/{family_member_id}', [ChildGrowthController::class, 'history']);
            });

            // Child Above Five Vital Over 5
            Route::prefix('/child-above-five-vital')->group(function () {
                Route::get('/{family_member_id}', [ChildAboveFiveVitalController::class, 'index']);
                Route::post('/store', [ChildAboveFiveVitalController::class, 'store']);
                Route::get('/edit/{id}', [ChildAboveFiveVitalController::class, 'edit']);
                Route::delete('/delete/{id}', [ChildAboveFiveVitalController::class, 'destroy']);
            });

            // Child Above Five Clinical Over 5
            Route::prefix('/child-above-five-clinical')->group(function () {
                Route::get('/{family_member_id}', [ChildAboveFiveClinicalController::class, 'index']);
                Route::post('/store', [ChildAboveFiveClinicalController::class, 'store']);
                Route::get('/edit/{id}', [ChildAboveFiveClinicalController::class, 'edit']);
                Route::delete('/delete/{id}', [ChildAboveFiveClinicalController::class, 'destroy']);
            });

            // Obesity Records
            Route::prefix('/obesity-records')->group(function () {
                Route::get('/{family_member_id}', [ObesityRecordController::class, 'index']);
                Route::post('/store', [ObesityRecordController::class, 'store']);
                Route::get('/edit/{id}', [ObesityRecordController::class, 'edit']);
                Route::delete('/delete/{id}', [ObesityRecordController::class, 'destroy']);
            });

            // Psychological Support Visit
            Route::prefix('/psychological-support-visit')->group(function () {
                Route::get('/{family_member_id}', [PsychologicalSupportVisitController::class, 'index']);
                Route::post('/store', [PsychologicalSupportVisitController::class, 'store']);
                Route::get('/edit/{id}', [PsychologicalSupportVisitController::class, 'edit'])->name('doctor.psychological-support.edit');
                Route::put('/update/{id}', [PsychologicalSupportVisitController::class, 'update']);
                Route::delete('/delete/{id}', [PsychologicalSupportVisitController::class, 'destroy']);
            });

            // Verbal Orders
            Route::prefix('/verbal-orders')->as('doctor.verbal-orders.')->group(function () {
                Route::get('/{family_member_id}', [VerbalOrderController::class, 'index'])->name('index');
                Route::get('/show/{id}', [VerbalOrderController::class, 'show'])->name('show');
                Route::post('/store', [VerbalOrderController::class, 'store'])->name('store');
                Route::get('/edit/{id}', [VerbalOrderController::class, 'edit'])->name('edit');
                Route::put('/update/{id}', [VerbalOrderController::class, 'update'])->name('update');
                Route::patch('/{id}/confirm', [VerbalOrderController::class, 'confirm'])->name('confirm');
                Route::delete('/delete/{id}', [VerbalOrderController::class, 'destroy'])->name('destroy');
            });

            // Radiological Request
            Route::prefix('/radiological-requests')->as('doctor.radiological-requests.')->group(function () {
                Route::get('/{family_member_id}', [RadiologicalRequestController::class, 'index'])->name('index');
                Route::post('/store', [RadiologicalRequestController::class, 'store'])->name('store');
                Route::get('/show/{id}', [RadiologicalRequestController::class, 'show'])->name('show');
                Route::get('/edit/{id}', [RadiologicalRequestController::class, 'edit'])->name('edit');
                Route::put('/update/{id}', [RadiologicalRequestController::class, 'update'])->name('update');
                Route::delete('/delete/{id}', [RadiologicalRequestController::class, 'destroy'])->name('destroy');
            });

            // Radiology Reports
            Route::prefix('/radiology-reports')->as('doctor.radiology-reports.')->group(function () {
                Route::post('/store', [RadiologyReportController::class, 'store'])->name('store');
                Route::get('/show/{id}', [RadiologyReportController::class, 'show'])->name('show');
                Route::get('/edit/{id}', [RadiologyReportController::class, 'edit'])->name('edit');
                Route::put('/update/{id}', [RadiologyReportController::class, 'update'])->name('update');
                // Route::delete('/delete/{id}', [RadiologyReportController::class, 'destroy'])->name('destroy');
            });

            // Referral 
            Route::prefix('/referrals')->as('doctor.referrals.')->group(function () {
                Route::get('/{family_member_id}', [ReferralController::class, 'index'])->name('index');
                Route::post('/store', [ReferralController::class, 'store'])->name('store');
                Route::get('/show/{id}', [ReferralController::class, 'show'])->name('show');
                Route::get('/edit/{id}', [ReferralController::class, 'edit'])->name('edit');
                Route::put('/update/{id}', [ReferralController::class, 'update'])->name('update');
                Route::delete('/delete/{id}', [ReferralController::class, 'destroy'])->name('destroy');
            });

            // Feedback Referral
            Route::prefix('/feedback-referrals')->as('doctor.feedback-referrals.')->group(function () {
                Route::post('/store', [FeedbackReferralController::class, 'store'])->name('store');
                Route::get('/show/{id}', [FeedbackReferralController::class, 'show'])->name('show');
                Route::get('/edit/{id}', [FeedbackReferralController::class, 'edit'])->name('edit');
                Route::put('/update/{id}', [FeedbackReferralController::class, 'update'])->name('update');
                Route::delete('/delete/{id}', [FeedbackReferralController::class, 'destroy'])->name('destroy');
            });

            // Physiotherapy Assessments
            Route::prefix('/physiotherapy-assessments')->as('doctor.physiotherapy-assessments.')->group(function () {
                Route::get('/{family_member_id}', [PhysiotherapyAssessmentController::class, 'index'])->name('index');                
                Route::post('/store', [PhysiotherapyAssessmentController::class, 'store'])->name('store');
                Route::get('/show/{id}', [PhysiotherapyAssessmentController::class, 'show'])->name('show');
                Route::put('/update/{id}', [PhysiotherapyAssessmentController::class, 'update'])->name('update');
                Route::delete('/delete/{id}', [PhysiotherapyAssessmentController::class, 'destroy'])->name('destroy');
            });

            // Critical Results
            Route::prefix('/critical-results')->as('doctor.critical-results.')->group(function () {
                // جلب قائمة الأطباء المتاحين للاستلام (Dropdown)
                Route::get('/receiving-doctors', [CriticalResultController::class, 'getReceivingDoctors'])->name('receiving-doctors');

                // العمليات الأساسية (CRUD)
                Route::get('/', [CriticalResultController::class, 'index'])->name('index'); 
                Route::post('/store', [CriticalResultController::class, 'store'])->name('store');
                Route::patch('/respond/{id}', [CriticalResultController::class, 'respondToResult']);
                Route::patch('/re-test/{id}', [CriticalResultController::class, 'reTestResult'])->name('critical-results.re-test');
                Route::get('/show/{id}', [CriticalResultController::class, 'show'])->name('show');
                Route::put('/update/{id}', [CriticalResultController::class, 'update'])->name('update');
                Route::delete('/delete/{id}', [CriticalResultController::class, 'destroy'])->name('destroy');

                // الإشعارات (Notifications)
                Route::get('/notifications', [CriticalResultController::class, 'getMyNotifications'])->name('notifications.index');
                Route::patch('/notifications/{id}/mark-as-read', [CriticalResultController::class, 'markAsRead'])->name('notifications.read');
            });

            // Dental Examinations
            Route::prefix('/dental-examinations')->as('doctor.dental-examinations.')->group(function () {
                // Route::get('/{family_member_id}', [DentalExaminationController::class, 'index'])->name('index');                
                Route::post('/store', [DentalExaminationController::class, 'store'])->name('store');
                Route::get('/show/{id}', [DentalExaminationController::class, 'show'])->name('show');
                Route::put('/update/{id}', [DentalExaminationController::class, 'update'])->name('update');
                Route::delete('/delete/{id}', [DentalExaminationController::class, 'destroy'])->name('destroy');
            });

            // Cardiovascular Risk Assessment 
            Route::prefix('/cv-risk-assessments')->as('doctor.cv-risk.')->group(function () {
                
                // 1. القائمة والعرض والحذف (General)
                Route::get('/{family_member_id}', [CvRiskAssessmentController::class, 'index'])->name('index');
                Route::get('/show/{id}', [CvRiskAssessmentController::class, 'show'])->name('show');
                Route::delete('/delete/{id}', [CvRiskAssessmentController::class, 'destroy'])->name('destroy');

                // 2. المرحلة الأولى (Step 1)
                Route::post('/store-step1', [CvRiskAssessmentController::class, 'storeStep1'])->name('storeStep1');
                Route::get('/edit-step1/{id}', [CvRiskAssessmentController::class, 'editStep1'])->name('editStep1');
                Route::put('/update-step1/{id}', [CvRiskAssessmentController::class, 'updateStep1'])->name('updateStep1');
                
                // 3. المرحلة الثانية (Step 2)
                Route::put('/store-step2/{id}', [CvRiskAssessmentController::class, 'storeStep2'])->name('storeStep2');
                Route::get('/edit-step2/{id}', [CvRiskAssessmentController::class, 'editStep2'])->name('editStep2');
                
                // 4. المرحلة الثالثة (Step 3)
                Route::put('/store-step3/{id}', [CvRiskAssessmentController::class, 'storeStep3'])->name('storeStep3');
                Route::get('/edit-step3/{id}', [CvRiskAssessmentController::class, 'editStep3'])->name('editStep3');
            });

            // Visits
            Route::post('/visits', [VisitController::class, 'store']);
            Route::get('/family-members/{family_member}/visits', [VisitController::class, 'index']);
            Route::get('/family-members/{family_member}/visits/{visit}', [VisitController::class, 'show']);
            Route::get('/family-members/{family_member}/visits/{visit}/edit', [VisitController::class, 'edit']);
            Route::put('/family-members/{family_member}/visits/{visit}', [VisitController::class, 'update']);
            Route::delete('/family-members/{family_member}/visits/{visit}', [VisitController::class, 'destroy']);

            //chronic-disease
            Route::apiResource('chronic-diseases', ChronicDiseaseController::class);

            //Chronic-disease-visits
            Route::apiResource('chronic-disease.disease-visits', ChronicDiseaseVisitController::class);

            //Pregnancy (Basic info)
            Route::apiResource('pregnancies', PregnancyController::class);

            //Pregnancy Visits
            Route::apiResource('pregnancy_visits', PregnancyVisitController::class);

            //Postnatal care
            Route::apiResource('postnatal-care', PostnatalCareController::class);

            //Family planning
            Route::apiResource('family-planning', FamilyPlanningController::class);

            //Follow Ups
            //nested 
            Route::apiResource('family-planning.follow-ups', FamilyPlanningFollowUpController::class);

            Route::apiResource('surgery-uterus', SurgeryUterusController::class);

            Route::apiResource('family-injections', FamilyInjectionController::class);

            Route::apiResource('premarital-screenings', PremaritalScreeningController::class);
        });
    });

// =========================================================================================================================== //
    
    // Admin
    Route::middleware('admin')->group(function () {
        Route::prefix('admin')->group(function () {    
            // Doctors Management
            Route::prefix('/doctors')->as('admin.doctors.')->group(function () {
                Route::get('/', [DoctorController::class, 'index'])->name('index');           // عرض كل الدكاترة
                Route::post('/store', [DoctorController::class, 'store'])->name('store');     // إضافة دكتور جديد
                Route::get('/show/{id}', [DoctorController::class, 'show'])->name('show');    // عرض بيانات دكتور محدد
                Route::put('/update/{id}', [DoctorController::class, 'update'])->name('update'); // تحديث بيانات دكتور
                Route::delete('/delete/{id}', [DoctorController::class, 'destroy'])->name('destroy'); // حذف دكتور
            });

            // Nurses Management
            Route::prefix('/nurses')->as('admin.nurses.')->group(function () {
                Route::get('/', [NurseController::class, 'index'])->name('index');           // عرض كل الممرضات (Paginated)
                Route::post('/store', [NurseController::class, 'store'])->name('store');     // إضافة ممرضة جديدة
                Route::get('/show/{id}', [NurseController::class, 'show'])->name('show');    // عرض بيانات ممرضة محددة
                Route::put('/update/{id}', [NurseController::class, 'update'])->name('update'); // تحديث بيانات ممرضة
                Route::delete('/delete/{id}', [NurseController::class, 'destroy'])->name('destroy'); // حذف ممرضة
            });
        });
    });

// =========================================================================================================================== //

    // Nurse
    Route::middleware('nurse')->group(function () {
        Route::prefix('nurse')->group(function () {
            // 
        });
    });

// =========================================================================================================================== //

    // Logout
    Route::post('/logout', [LogoutController::class, 'logout']);
});
