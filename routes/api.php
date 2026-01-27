<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Doctor\FamilyController;
use App\Http\Controllers\Doctor\GeneralExaminationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/login', [LoginController::class, 'login']);

//Doctor
Route::middleware(['auth:sanctum', 'doctor'])->group(function () {
    // Family
    Route::get('/families', [FamilyController::class, 'index']);
    Route::post("/family/store" , [FamilyController::class, 'store']);
    Route::post("/family/store/member/{family_id}" , [FamilyController::class, 'storeMembers']);
    Route::patch("/family/assign/doctor/{family_id}" , [FamilyController::class, 'assignDoctors']);
    Route::post("/family/store/medical/history/{family_id}" , [FamilyController::class, 'storeMedicalHistory']);
    Route::post("/family/store/death/record/{family_id}" , [FamilyController::class, 'storeDeathRecords']);
    Route::post("/family/store/housing/info/{family_id}" , [FamilyController::class, 'storeHousingInfo']);
    Route::post("/family/store/social/research/{family_id}" , [FamilyController::class, 'storeSocialResearch']);
    Route::get("/families/show/{family_id}", [FamilyController::class, "show"]);
    Route::get("/family/edit/{family_id}", [FamilyController::class, "edit"]);
    Route::put("/family/update/{family_id}", [FamilyController::class, "update"]);
    Route::get("/family/edit/members/{family_id}", [FamilyController::class, "editMembers"]);
    Route::put("/family/update/members/{family_id}", [FamilyController::class, "updateMembers"]);
    Route::get("/family/assign/doctor/edit/{family_id}", [FamilyController::class, "editAssignDoctors"]);
    Route::get('/family/medical-history/edit/{family_id}', [FamilyController::class, 'editMedicalHistory']);
    Route::put('/family/medical-history/update/{family_id}', [FamilyController::class, 'updateMedicalHistory']);
    Route::get('/family/death-records/edit/{family_id}', [FamilyController::class, 'editDeathRecords']);
    Route::get('/family/housing-info/edit/{family_id}', [FamilyController::class, 'editHousingInfo']);
    Route::get('/family/social-research/edit/{family_id}', [FamilyController::class, 'editSocialResearch']);

    //General Examination
    Route::prefix('doctor')->group(function () {
        Route::post('/physical-examination/history', [GeneralExaminationController::class, 'store']);
        Route::post('/general-examination/vitals', [GeneralExaminationController::class, 'storeVitals']);
        Route::patch('/general-examination/systemic-exam', [GeneralExaminationController::class, 'storeSystemicExamination']);
        Route::patch('/general-examination/final-exam', [GeneralExaminationController::class, 'storeFinalAssessment']);
        Route::get('/physical-examination/edit/{family_member_id}', [GeneralExaminationController::class, 'edit']);
        Route::get('/general-examination/vitals/edit/{physical_examination_id}', [GeneralExaminationController::class, 'editVitals']);
        Route::get('/general-examination/systemic-exam/edit/{physical_examination_id}', [GeneralExaminationController::class, 'editSystemic']);
        Route::get('/general-examination/final-exam/edit/{physical_examination_id}', [GeneralExaminationController::class, 'editFinalAssessment']);
    });
});

// Admin
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
});

