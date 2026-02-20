<?php

namespace App\Http\Controllers\Doctor;

use App\Traits\ApiResponse;
use App\Models\ChronicDisease;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChronicDiseaseRequest;
use App\Http\Requests\UpdateChronicDiseaseRequest;
use App\Http\Resources\ChronicDiseaseResource;

class ChronicDiseaseController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $diseases = ChronicDisease::with(['familyMember'])->get();

        return ApiResponse::successResponse(
            "The diseases returned successfully",
            200,
            ChronicDiseaseResource::collection($diseases)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChronicDiseaseRequest $request)
    {
        $disease = ChronicDisease::create($request->validated());

        return ApiResponse::successResponse(
            "Chronic disease created successfully",
            201,
            new ChronicDiseaseResource($disease)
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(ChronicDisease $chronicDisease)
    {
        
        return ApiResponse::successResponse(
            'Chronic disease returned successfully',
            200,
            new ChronicDiseaseResource($chronicDisease->load('familyMember'))
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChronicDiseaseRequest $request, ChronicDisease $chronicDisease)
    {
        $chronicDisease->update($request->validated());

        return ApiResponse::successResponse(
            'Chronic disease updated successfully',
            200,
            new ChronicDiseaseResource($chronicDisease->load('familyMember'))
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChronicDisease $chronicDisease)
    {
        $chronicDisease->delete();

        return ApiResponse::successResponse(
            "Chronic disease deleted successfully",
            200
        );
    }
}
