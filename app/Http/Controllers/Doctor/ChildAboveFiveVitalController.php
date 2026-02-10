<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StoreChildAboveFiveVitalRequest;
use App\Http\Requests\Doctor\StoreChildFollowupRequest;
use App\Models\ChildAboveFiveVital;
use App\Traits\ApiResponse;
use App\Traits\HasDoctorContext;
use Illuminate\Http\Request;

class ChildAboveFiveVitalController extends Controller
{
    use HasDoctorContext;
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index($family_member_id)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $childFollowup = ChildAboveFiveVital::where('family_member_id', $family_member_id)->paginate(4);
        if ($childFollowup->isEmpty())
        {
            return ApiResponse::errorResponse(
                "Empty Clinical History: No specialized medical examinations have been recorded for this member yet.",
                404
            );
        }

        $childFollowup->makeHidden(["family_member_id", "visit_id", 'created_at', 'updated_at']);
        return ApiResponse::successResponse(
            "Child growth data retrieved successfully.",
            200,
            $childFollowup
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChildAboveFiveVitalRequest $request)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $data = $request->validated();

        $childFollowup = ChildAboveFiveVital::updateOrCreate(
            [
                'visit_id' => $data['visit_id'],
                'family_member_id' => $data['family_member_id'],
            ],
            [
                'age' => $data['age'],
                'weight' => $data['weight'],
                'height' => $data['height'],
                'vaccine_dt' => $data['vaccine_dt'] ?? false,
                'vaccine_meningitis' => $data['vaccine_meningitis'] ?? false,
                'other_vaccines' => $data['other_vaccines'] ?? null,
                'vaccine_date' => $data['vaccine_date'] ?? null,
                'notes' => $data['notes'] ?? null,
            ]
        );

        $message = $childFollowup->wasRecentlyCreated 
            ? "Child growth and follow-up data saved successfully." 
            : "Child growth data updated and synchronized successfully.";
            
        $status = $childFollowup->wasRecentlyCreated ? 201 : 200;

        return ApiResponse::successResponse(
            $message,
            $status,
            $childFollowup
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $childFollowup = ChildAboveFiveVital::find($id);
        if (!$childFollowup)
        {
            return ApiResponse::errorResponse(
                "Child follow-up record not found.",
                404
            );
        }

        $childFollowup->makeHidden(['id', 'created_at', 'updated_at']);
        return ApiResponse::successResponse(
            "Child growth data retrieved successfully.",
            200,
            $childFollowup
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $childFollowup = ChildAboveFiveVital::find($id);
        if (!$childFollowup)
        {
            return ApiResponse::errorResponse(
                "Target record not found: This specific follow-up entry does not exist in the growth history.",
                404
            );
        }
        $childFollowup->delete();

        return ApiResponse::successResponse(
            "Child growth data deleted successfully.",
            200
        );
    }
}
