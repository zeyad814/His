<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StoreFamilyPlanningFollowUpRequest;
use App\Http\Requests\Doctor\UpdateFamilyPlanningFollowUpRequest;
use App\Http\Resources\FamilyPlanningFollowUpResource;
use App\Models\FamilyPlanning;
use App\Models\FamilyPlanningFollowUp;
use App\Traits\ApiResponse;
use App\Traits\HasDoctorContext;
use Illuminate\Http\Request;

class FamilyPlanningFollowUpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use HasDoctorContext;
    public function index(FamilyPlanning $family_planning)
    {
        $followUps = $family_planning->followUps()->with('doctor.user')->latest()->get();

        return ApiResponse::successResponse(
            'Follow-up history retrieved successfully',
            200,
            FamilyPlanningFollowUpResource::collection($followUps)

        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFamilyPlanningFollowUpRequest $request, FamilyPlanning $family_planning)
    {
        $validated = $request->validated();
        $validated['family_planning_id'] = $family_planning->id;

        $validated['doctor_id'] = $this->getAuthenticatedDoctor()->id;

        $followUp = FamilyPlanningFollowUp::create($validated);

        return ApiResponse::successResponse(
            'Follow-up visit recorded successfully.',
            201,
            new FamilyPlanningFollowUpResource($followUp->load('doctor.user'))

        );
    }

    /**
     * Display the specified resource.
     */
    public function show(FamilyPlanning $family_planning, FamilyPlanningFollowUp $follow_up)
    {
        $follow_up->load('doctor.user');

        return ApiResponse::successResponse(
            'Follow-up details retrieved successfully.',
            200,
            new FamilyPlanningFollowUpResource($follow_up)

        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFamilyPlanningFollowUpRequest $request, FamilyPlanning $family_planning, FamilyPlanningFollowUp $follow_up)
    {
        if ($follow_up->family_planning_id !== $family_planning->id) {
            return ApiResponse::errorResponse('Data mismatch: This follow-up does not belong to the patient record.', 400);
        }

        $follow_up->update($request->validated());
        return ApiResponse::successResponse(
            'Follow-up updated successfully.',
            200,
            new FamilyPlanningFollowUpResource($follow_up->load('doctor.user'))
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FamilyPlanning $family_planning, FamilyPlanningFollowUp $follow_up)
    {
        if ($follow_up->family_planning_id !== $family_planning->id) {
            return ApiResponse::errorResponse('Unauthorized action.', 403);
        }

        $follow_up->delete();

        return ApiResponse::successResponse('Follow-up deleted successfully.', 200);
    }
}
