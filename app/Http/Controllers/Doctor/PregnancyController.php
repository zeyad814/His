<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StorePregnancyRequest;
use App\Http\Requests\Doctor\UpdatePregnancyRequest;
use App\Http\Resources\PregnancyResource;
use App\Models\Pregnancy;
use App\Models\PregnancyVisit;
use App\Traits\ApiResponse;


class PregnancyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pregnancies = Pregnancy::with(['familyMember', 'pregnancyVisits'])->get();

        return ApiResponse::successResponse(
            'Pregnancy data returned Successfully',
            200,
            PregnancyResource::collection($pregnancies)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePregnancyRequest $request)
    {
        $validated = $request->validated();

        $pregnancy = Pregnancy::create($validated);

        return ApiResponse::successResponse(
            'Pregnancy record created successfully',
            201,
            new PregnancyResource($pregnancy->load(['familyMember', 'pregnancyVisits']))
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Pregnancy $pregnancy)
    {
        $pregnancy->load(['familyMember', 'pregnancyVisits']);

        return ApiResponse::successResponse(
            'Pregnancy data retrieved successfully',
            200,
            new PregnancyResource($pregnancy)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePregnancyRequest $request, Pregnancy $pregnancy)
    {
        $pregnancy->update($request->validated());

        return ApiResponse::successResponse(
            'Pregnancy record updated successfully',
            200,
            new PregnancyResource($pregnancy->load(['familyMember', 'pregnancyVisits']))
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pregnancy $pregnancy)
    {
        $pregnancy->delete();

        return ApiResponse::successResponse(
            'Pregnancy record deleted successfully',
            200
        );
    }
}
