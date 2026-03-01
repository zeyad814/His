<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StorePhysiotherapyAssessmentRequest;
use App\Http\Requests\Doctor\UpdatePhysiotherapyAssessmentRequest;
use App\Http\Resources\PhysiotherapyAssessmentResource;
use App\Models\FamilyMember;
use App\Models\PhysiotherapyAssessment;
use App\Models\Visit;
use App\Traits\ApiResponse;
use App\Traits\HasDoctorContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PhysiotherapyAssessmentController extends Controller
{
    use HasDoctorContext;
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index($family_member_id)
    {
        $this->getAuthenticatedDoctor();
        $member = FamilyMember::find($family_member_id);
        if (!$member)
        {
            return ApiResponse::errorResponse("The specified Family Member ID was not found in our records.", 404);
        }

        $physiotherapies = PhysiotherapyAssessment::where("family_member_id", $family_member_id)
            ->latest()
            ->paginate(5);

        if ($physiotherapies->isEmpty())
        {
            return ApiResponse::errorResponse("No physiotherapy assessments found for this family member.", 404);
        }

        return ApiResponse::successResponse(
            "Physiotherapy assessments retrieved successfully",
            200,
            PhysiotherapyAssessmentResource::collection($physiotherapies)->response()->getData(true)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePhysiotherapyAssessmentRequest $request)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $data = $request->validated();
        $data["doctor_id"] = $doctor->id;

        $visit = Visit::find($data["visit_id"]);
        if (!$visit)
        {
            return ApiResponse::errorResponse("The specified Visit ID was not found in our records.", 404);
        }

        if($visit->visit_type !== "زيارة دورية")
        {
            return ApiResponse::errorResponse("Physiotherapy assessment can only be added to periodic visits.", 400);
        }

        DB::beginTransaction();
        try
        {
            $physiotherapy = PhysiotherapyAssessment::create($data);
            DB::commit();
            return ApiResponse::successResponse(
                "Physiotherapy assessment created successfully",
                201,
                new PhysiotherapyAssessmentResource($physiotherapy)
            );
        }
        catch (\Throwable $th)
        {
            DB::rollBack();
            return ApiResponse::errorResponse("Something went wrong while creating the assessment", 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $this->getAuthenticatedDoctor();
        $physiotherapy = PhysiotherapyAssessment::find($id);
        if (!$physiotherapy)
        {
            return ApiResponse::errorResponse("The requested physiotherapy assessment could not be located in our system.", 404);
        }

        return ApiResponse::successResponse(
            "Physiotherapy assessment retrieved successfully",
            200,
            new PhysiotherapyAssessmentResource($physiotherapy)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePhysiotherapyAssessmentRequest $request, $id)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $data = $request->validated();
        $data["doctor_id"] = $doctor->id;

        $physiotherapy = PhysiotherapyAssessment::find($id);
        if (!$physiotherapy)
        {
            return ApiResponse::errorResponse("The requested physiotherapy assessment could not be located in our system.", 404);
        }

        DB::beginTransaction();
        try
        {
            $physiotherapy->update($data);
            DB::commit();
            return ApiResponse::successResponse(
                "Physiotherapy assessment updated successfully",
                200,
                new PhysiotherapyAssessmentResource($physiotherapy)
            );
        }
        catch (\Throwable $th)
        {
            DB::rollBack();
            return ApiResponse::errorResponse("Something went wrong while updating the assessment", 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->getAuthenticatedDoctor();
        $physiotherapy = PhysiotherapyAssessment::find($id);
        if (!$physiotherapy)
        {
            return ApiResponse::errorResponse("The requested physiotherapy assessment could not be located in our system.", 404);
        }

        DB::beginTransaction();
        try
        {
            $physiotherapy->delete();

            DB::commit();
            return ApiResponse::successResponse(
                "Physiotherapy assessment deleted successfully",
                200
            );
        }
        catch (\Throwable $th)
        {
            DB::rollBack();
            return ApiResponse::errorResponse("Something went wrong while deleting the order", 500);
        }
    }
}
