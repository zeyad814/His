<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StoreFamilyPlanningRequest;
use App\Http\Requests\Doctor\UpdateFamilyPlanningRequest;
use App\Http\Resources\FamilyPlanningResource;
use App\Models\FamilyPlanning;
use App\Traits\ApiResponse;
use App\Traits\HasDoctorContext;
use Illuminate\Http\Request;

class FamilyPlanningController extends Controller
{
    use HasDoctorContext;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = FamilyPlanning::with(['familyMember', 'doctor.user'])->latest()->get();

        return ApiResponse::successResponse(
            'Family Planning data returned Successfully',
            200,
            FamilyPlanningResource::collection($records)

        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFamilyPlanningRequest $request)
    {
        $validated = $request->validated();

        $doctor = $this->getAuthenticatedDoctor();
        $validated['doctor_id'] = $doctor->id;

        $familyPlanning = FamilyPlanning::create($validated);

        $familyPlanning->load(['familyMember', 'doctor.user']);

        return ApiResponse::successResponse(
            'Family Planning Record Created Successfully',
            201,
            new FamilyPlanningResource($familyPlanning)

        );
    }

    /**
     * Display the specified resource.
     */
    public function show(FamilyPlanning $familyPlanning)
    {
        $familyPlanning->load(['familyMember', 'doctor.user']);

        return ApiResponse::successResponse(
            'Family Planning record retrieved Successfully',
            200,
            new FamilyPlanningResource($familyPlanning)

        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFamilyPlanningRequest $request, FamilyPlanning $familyPlanning)
    {
        $familyPlanning->update($request->validated());
        $familyPlanning->load(['familyMember', 'doctor.user']);

        return ApiResponse::successResponse(
        'Family Planning record updated successfully',
        200,
        new FamilyPlanningResource($familyPlanning)
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FamilyPlanning $familyPlanning)
    {
        $familyPlanning->delete();

        return ApiResponse::successResponse(
            'Family Planning record deleted successfully',
            200

        );
    }
}
