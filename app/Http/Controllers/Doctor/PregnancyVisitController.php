<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StorePregnancyVisitRequest;
use App\Http\Requests\Doctor\UpdatePregnancyVisitRequest;
use App\Http\Resources\PregnancyVisitResource;
use App\Models\PregnancyVisit;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class PregnancyVisitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $visits = PregnancyVisit::with(['pregnancy.familyMember', 'doctor', 'visit'])->get();

        return ApiResponse::successResponse(
            'All pregnancy visits retrieved successfully',
            200,
            PregnancyVisitResource::collection($visits)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePregnancyVisitRequest $request)
    {
        $validated = $request->validated();

        $visit = PregnancyVisit::create($validated);

        return ApiResponse::successResponse(
            'Pregnancy visit recoreded successfully',
            201,
            new PregnancyVisitResource($visit->load(['pregnancy.familyMember', 'doctor']))
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(PregnancyVisit $pregnancyVisit)
    {
        $pregnancyVisit->load(['pregnancy.familyMember', 'doctor', 'visit']);

        return ApiResponse::successResponse(
            'Pregnancy visit details retrieved',
            200,
            new PregnancyVisitResource($pregnancyVisit)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePregnancyVisitRequest $request, PregnancyVisit $pregnancyVisit)
    {
        $pregnancyVisit->update($request->validated());

        return ApiResponse::successResponse(
            'Pregnancy visit record updated successfully',
            200,
            new PregnancyVisitResource($pregnancyVisit->load(['pregnancy.familyMember', 'doctor']))
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PregnancyVisit $pregnancyVisit)
    {
        $pregnancyVisit->delete();

        return ApiResponse::successResponse('Pregnancy visit deleted successfully', 200);
    }
}
