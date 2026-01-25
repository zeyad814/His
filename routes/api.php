<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Doctor\FamilyController;
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
    Route::post("/store/family" , [FamilyController::class, 'store']);
    Route::post("/store/family/member/{family_id}" , [FamilyController::class, 'storeMembers']);
    Route::patch("/assign/family/doctor/{family_id}" , [FamilyController::class, 'assignDoctors']);
    Route::post("/store/family/medical/history/{family_id}" , [FamilyController::class, 'storeMedicalHistory']);
    Route::post("/store/family/death/record/{family_id}" , [FamilyController::class, 'storeDeathRecords']);
    Route::post("/store/family/housing/info/{family_id}" , [FamilyController::class, 'storeHousingInfo']);
    Route::post("/store/family/social/research/{family_id}" , [FamilyController::class, 'storeSocialResearch']);
});

// Admin
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
});

