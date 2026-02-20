<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChronicDiseaseVisitRequest;
use App\Http\Requests\UpdateChronicDiseaseVisitRequest;
use App\Http\Resources\ChronicDiseaseVisitResource;
use App\Models\ChronicDisease;
use App\Models\ChronicDiseaseVisit;
use App\Models\Visit;
use App\Traits\ApiResponse;
use App\Traits\HasDoctorContext;


class ChronicDiseaseVisitController extends Controller
{
    use HasDoctorContext;
    /**
     * Display a listing of the resource.
     */
   public function index($chronic_disease_id)
    {
        $diseaseVisits = ChronicDiseaseVisit::where("chronic_disease_id", $chronic_disease_id)
           ->get();

        return ApiResponse::successResponse(
            'Chronic disease visits returned successfully',
            200,
            ChronicDiseaseVisitResource::collection($diseaseVisits)
        );
    }

    public function store(StoreChronicDiseaseVisitRequest $request, Visit $visit, ChronicDisease $chronicDisease)
    {
        // منع التكرار (نفس منطقك)
        $exists = $chronicDisease->diseaseVisits()->where('visit_id', $visit->id)->exists();

        if ($exists) {
            return ApiResponse::errorResponse('This chronic disease already exists in this visit', 409);
        }

        $validated = $request->validated();
        $doctor = $this->getAuthenticatedDoctor();
        $validated['doctor_id'] = $doctor->id;
        $validated['visit_id'] = $visit->id;

        $diseaseVisit = $chronicDisease->diseaseVisits()->create($validated);

        return ApiResponse::successResponse(
            'Disease visit created successfully',
            201,
            new ChronicDiseaseVisitResource($diseaseVisit) // استخدام الريسورس
        );
    }

    public function show(Visit $visit, ChronicDisease $chronicDisease, ChronicDiseaseVisit $diseaseVisit)
    {
        // التأكد من التبعية (منطقك الأصلي)
        if ($diseaseVisit->visit_id !== $visit->id || $diseaseVisit->chronic_disease_id !== $chronicDisease->id) {
            return ApiResponse::errorResponse('Unauthorized access to this disease visit', 403);
        }

        return ApiResponse::successResponse(
            'Disease visit returned successfully',
            200,
            new ChronicDiseaseVisitResource($diseaseVisit)
        );
    }

    public function update(UpdateChronicDiseaseVisitRequest $request, Visit $visit, ChronicDisease $chronicDisease, ChronicDiseaseVisit $diseaseVisit)
    {
        if ($diseaseVisit->visit_id !== $visit->id || $diseaseVisit->chronic_disease_id !== $chronicDisease->id) {
            return ApiResponse::errorResponse('Unauthorized access', 403);
        }

        $diseaseVisit->update($request->validated());

        return ApiResponse::successResponse(
            'Disease visit updated successfully',
            200,
            new ChronicDiseaseVisitResource($diseaseVisit)
        );
    }

    public function destroy(Visit $visit, ChronicDisease $chronicDisease, ChronicDiseaseVisit $diseaseVisit)
    {
        if ($diseaseVisit->visit_id !== $visit->id || $diseaseVisit->chronic_disease_id !== $chronicDisease->id) {
            return ApiResponse::errorResponse('Unauthorized access', 403);
        }

        $diseaseVisit->delete();
        return ApiResponse::successResponse('Disease visit deleted successfully', 200);
    }
}
