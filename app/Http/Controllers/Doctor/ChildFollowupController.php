<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StoreChildFollowupRequest;
use App\Models\ChildFollowup;
use App\Traits\ApiResponse;
use App\Traits\HasDoctorContext;
use Illuminate\Http\Request;

class ChildFollowupController extends Controller
{
    use HasDoctorContext;
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChildFollowupRequest $request)
    {
        $this->getAuthenticatedDoctor();
        $data = $request->validated();

        $childFollowup = ChildFollowup::updateOrCreate(
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
        $this->getAuthenticatedDoctor();
        $childFollowup = ChildFollowup::find($id);
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
        $this->getAuthenticatedDoctor();
        $childFollowup = ChildFollowup::find($id);
        if (!$childFollowup)
        {
            return ApiResponse::errorResponse(
                "Child follow-up record not found.",
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
