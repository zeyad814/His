<?php

namespace App\Http\Controllers\Doctor;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Models\ChronicDisease;
use App\Traits\HasDoctorContext;
use App\Http\Controllers\Controller;
use App\Models\ChronicDiseaseVisit;
use App\Models\Visit;

class ChronicDiseaseVisitController extends Controller
{
    use HasDoctorContext;
    /**
     * Display a listing of the resource.
     */
    public function index(Visit $visit, ChronicDisease $chronicDisease)
    {
        // نتأكد إن المرض المزمن تابع للزيارة
        if (!$chronicDisease->diseaseVisits()->where('visit_id', $visit->id)->exists()) {
            return ApiResponse::errorResponse(
                'This chronic disease does not belong to this visit',
                403
            );
        }
        $diseaseVisits = $chronicDisease->diseaseVisits()
            ->where('visit_id', $visit->id)
            ->latest('visit_date')->get();

        return ApiResponse::successResponse(
            'Chronic disease visits returned successfully',
            200,
            $diseaseVisits
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Visit $visit, ChronicDisease $chronicDisease)
    {
        $validated = $request->validate([
            'complain' => 'required|string',
            'exam' => 'nullable|string',
            'vital_signs' => 'nullable|string',
            'investigations' => 'nullable|string',
            'management' => 'nullable|string',
            'visit_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        //  prevent duplicate disease in same visit
        $exists = $chronicDisease->diseaseVisits()
            ->where('visit_id', $visit->id)
            ->exists();

        if ($exists) {
            return ApiResponse::errorResponse(
                'This chronic disease already exists in this visit',
                409
            );
        }


        $doctor = $this->getAuthenticatedDoctor();
        $validated['doctor_id'] = $doctor->id;
        $validated['visit_id'] = $visit->id;


        $diseaseVisit = $chronicDisease->diseaseVisits()->create($validated);

        return ApiResponse::successResponse(
            'Disease visit created successfully',
            201,
            $diseaseVisit
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Visit $visit, ChronicDisease $chronicDisease, ChronicDiseaseVisit $diseaseVisit)
    {
        // نتأكد إن السجل تابع لنفس الزيارة
        if ($diseaseVisit->visit_id !== $visit->id) {
            return ApiResponse::errorResponse(
                'This disease visit does not belong to this visit',
                403
            );
        }

        // نتأكد إن السجل تابع لنفس المرض المزمن
        if ($diseaseVisit->chronic_disease_id !== $chronicDisease->id) {
            return ApiResponse::errorResponse(
                'This disease visit does not belong to this chronic disease',
                403
            );
        }

        return ApiResponse::successResponse(
            'Disease visit returned successfully',
            200,
            $diseaseVisit
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Visit $visit, ChronicDisease $chronicDisease, ChronicDiseaseVisit $diseaseVisit)
    {
        if ($diseaseVisit->visit_id !== $visit->id) {
            return ApiResponse::errorResponse(
                'This disease visit does not belong to this visit',
                403
            );
        }

        if ($diseaseVisit->chronic_disease_id !== $chronicDisease->id) {
            return ApiResponse::errorResponse(
                'This disease visit does not belong to this chronic disease',
                403
            );
        }

        $validated = $request->validate([
            'complain' => 'nullable|string',
            'exam' => 'nullable|string',
            'vital_signs' => 'nullable|string',
            'investigations' => 'nullable|string',
            'management' => 'nullable|string',
            'visit_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $diseaseVisit->update($validated);

        return ApiResponse::successResponse(
            'Disease visit updated successfully',
            200,
            $diseaseVisit
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Visit $visit, ChronicDisease $chronicDisease, ChronicDiseaseVisit $diseaseVisit)
    {
        if ($diseaseVisit->visit_id !== $visit->id) {
            return ApiResponse::errorResponse(
                'This disease visit does not belong to this visit',
                403
            );
        }

        if ($diseaseVisit->chronic_disease_id !== $chronicDisease->id) {
            return ApiResponse::errorResponse(
                'This disease visit does not belong to this chronic disease',
                403
            );
        }

        $diseaseVisit->delete();

        return ApiResponse::successResponse(
            'Disease visit deleted successfully',
            200
        );
    }
}
