<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StoreFamilyInjectionRequest;
use App\Http\Requests\Doctor\UpdateFamilyInjectionRequest;
use App\Http\Resources\FamilyInjectionResource;
use App\Models\FamilyInjection;
use App\Traits\ApiResponse;
use App\Traits\HasDoctorContext;


class FamilyInjectionController extends Controller
{
    use HasDoctorContext;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $injections = FamilyInjection::with(['familyMember.family', 'doctor'])
            ->latest()->paginate(10);

        return ApiResponse::successResponse(
            'Injections list retrieved successfully',
            200,
            FamilyInjectionResource::collection($injections)->response()->getData(true)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFamilyInjectionRequest $request)
    {
        $validated = $request->validated();

        $doctor = $this->getAuthenticatedDoctor();
        $validated['doctor_id'] = $doctor->id;

        $injection = FamilyInjection::create($validated);

        return ApiResponse::successResponse(
            'Injection consent recorded successfully',
            201,
            new FamilyInjectionResource($injection)
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(FamilyInjection $family_injection)
    {
        $family_injection->load(['familyMember.family', 'doctor']);

        return ApiResponse::successResponse(
            'Injection details retrieved successfully',
            200,
            new FamilyInjectionResource($family_injection)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFamilyInjectionRequest $request, FamilyInjection $family_injection)
    {
        $family_injection->update($request->validated());

        return ApiResponse::successResponse(
            'Injection record updated successfully',
            200,
            new FamilyInjectionResource($family_injection->load(['familyMember.family', 'doctor']))
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FamilyInjection $family_injection)
    {
        $family_injection->delete();

        return ApiResponse::successResponse(
            'Injection record deleted successfully',
            200,
        );
    }
}
