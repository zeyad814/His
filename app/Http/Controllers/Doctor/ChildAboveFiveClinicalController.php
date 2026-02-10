<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StoreChildAboveFiveClinicalRequest;
use App\Models\ChildAboveFiveClinical;
use App\Traits\ApiResponse;
use App\Traits\HasDoctorContext;
use Illuminate\Http\Request;

class ChildAboveFiveClinicalController extends Controller
{
    use HasDoctorContext;
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index($family_member_id)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $childClinicals = ChildAboveFiveClinical::where('family_member_id', $family_member_id)->paginate(4);
        if ($childClinicals->isEmpty())
        {
            return ApiResponse::errorResponse(
                "Empty Clinical History: No specialized medical examinations have been recorded for this member yet.",
                404
            );
        }

        $childClinicals->makeHidden(["family_member_id", "visit_id", 'created_at', 'updated_at']);
        return ApiResponse::successResponse(
            "Child clinical data retrieved successfully.",
            200,
            $childClinicals
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChildAboveFiveClinicalRequest $request)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $data = $request->validated();

        $childClinical = ChildAboveFiveClinical::updateOrCreate(
            [
                'visit_id' => $data['visit_id'],
                'family_member_id' => $data['family_member_id'],
            ],
            [
                'age' => $data['age'],
                'clinical_assessment' => $data['clinical_assessment'] ?? null,
                'nutritional_assessment' => $data['nutritional_assessment'] ?? null,
                'psychiatric_screening' => $data['psychiatric_screening'] ?? null,
                'school_achievement' => $data['school_achievement'] ?? null,
                'hb' => $data['hb'] ?? null,
                'urine' => $data['urine'] ?? null,
                'stool' => $data['stool'] ?? null,
                'other_investigations' => $data['other_investigations'] ?? null,
                'health_ed_parents' => $data['health_ed_parents'] ?? false,
                'health_ed_child' => $data['health_ed_child'] ?? false,
                'remarks' => $data['remarks'] ?? null,
                'doctor_id' => $doctor->id,
            ]
        );

        $message = $childClinical->wasRecentlyCreated 
            ? "Child clinical data saved successfully." 
            : "Child clinical data updated and synchronized successfully.";
            
        $status = $childClinical->wasRecentlyCreated ? 201 : 200;

        return ApiResponse::successResponse(
            $message,
            $status,
            $childClinical
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $childClinical = ChildAboveFiveClinical::find($id);
        if (!$childClinical)
        {
            return ApiResponse::errorResponse(
                "Child clinical record not found.",
                404
            );
        }

        $childClinical->makeHidden(['id', 'created_at', 'updated_at']);
        return ApiResponse::successResponse(
            "Child clinical data retrieved successfully.",
            200,
            $childClinical
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $childClinical = ChildAboveFiveClinical::find($id);
        if (!$childClinical)
        {
            return ApiResponse::errorResponse(
                "Transaction Failed: Clinical record not found or has already been removed.",
                404
            );
        }

        $childClinical->delete();
        return ApiResponse::successResponse(
            "Child clinical data deleted successfully.",
            200,
            // $childClinical
        );
    }
}
