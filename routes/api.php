<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Doctor\ChronicDiseaseController;
use App\Http\Controllers\Doctor\ChronicDiseaseVisitController;
use App\Http\Controllers\Doctor\DiabetesFollowUpController;
use App\Http\Controllers\Doctor\VisitController;
use App\Http\Controllers\Doctor\FamilyController;
use App\Http\Controllers\Doctor\GeneralExaminationController;
use App\Http\Controllers\Doctor\HypertensionStepController;
use App\Http\Controllers\Doctor\SignificantDataController;
use App\Models\Visit;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [LoginController::class, 'login']);

// Doctor
Route::middleware(['auth:sanctum', 'doctor'])->group(function () {

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
    Route::apiResource('visits.chronic-diseases.disease-visits', ChronicDiseaseVisitController::class);

});

// Admin
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
});
