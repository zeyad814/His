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
    public function index(ChronicDisease $chronic_disease)
    {

        $visits = $chronic_disease->diseaseVisits()
            ->with(['doctor.user', 'visit', 'chronicDisease'])
            ->latest('visit_date')->get();

        return ApiResponse::successResponse(
            'Disease visits returned successfully',
            200,
            ChronicDiseaseVisitResource::collection($visits)
        );
    }

    public function store(StoreChronicDiseaseVisitRequest $request, ChronicDisease $chronic_disease)
    {
        $doctor = $this->getAuthenticatedDoctor();

        $validated = $request->validated();

        $visit = Visit::findOrFail($validated['visit_id']);
        if ($visit->visit_type !== 'أمراض مزمنة') {
            return ApiResponse::errorResponse('This visit does not belong to Chronic diseases', 422);
        }

        $validated['doctor_id'] = $doctor->id;
        $validated['chronic_disease_id'] = $chronic_disease->id;

        $diseaseVisit = ChronicDiseaseVisit::create($validated);

        return ApiResponse::successResponse(
            'Disease visit created successfully',
            201,
            new ChronicDiseaseVisitResource($diseaseVisit->load(['doctor.user', 'visit', 'chronicDisease']))
        );
    }

    public function show(ChronicDisease $chronic_disease, ChronicDiseaseVisit $disease_visit)
    {
        if ($disease_visit->chronic_disease_id !== $chronic_disease->id) {
            return ApiResponse::errorResponse('This visit does not belong to Chronic diseases', 403);
        }


        $disease_visit->load(['doctor.user', 'visit', 'chronicDisease']);

        return ApiResponse::successResponse(
            'Disease visit returned successfully',
            200,
            new ChronicDiseaseVisitResource($disease_visit)
        );
    }

    public function update(UpdateChronicDiseaseVisitRequest $request, ChronicDisease $chronic_disease, ChronicDiseaseVisit $disease_visit)
    {
        $this->getAuthenticatedDoctor();

        if ($disease_visit->chronic_disease_id !== $chronic_disease->id) {
            return ApiResponse::errorResponse('This visit does not belong to Chronic diseases', 403);
        }
        $disease_visit->update($request->validated());

        return ApiResponse::successResponse(
            'Disease visit updated successfully',
            200,
            new ChronicDiseaseVisitResource($disease_visit->load(['doctor.user', 'visit', 'chronicDisease']))
        );
    }

    public function destroy(ChronicDisease $chronic_disease, ChronicDiseaseVisit $disease_visit)
    {
        $this->getAuthenticatedDoctor();
        if ($disease_visit->chronic_disease_id !== $chronic_disease->id) {
            return ApiResponse::errorResponse('This visit does not belong to Chronic diseases', 403);
        }

        $disease_visit->delete();
        return ApiResponse::successResponse('Disease visit deleted successfully', 200);
    }
}
