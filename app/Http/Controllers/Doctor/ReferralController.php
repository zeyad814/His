<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StoreReferralRequest;
use App\Http\Requests\Doctor\UpdateReferralRequest;
use App\Http\Resources\ReferralResource;
use App\Models\Referral;
use App\Traits\ApiResponse;
use App\Traits\HasDoctorContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReferralController extends Controller
{
    use HasDoctorContext;
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index($family_member_id)
    {
        $this->getAuthenticatedDoctor();
        $referrals = Referral::with("feedbackReferral")
            ->where("family_member_id" , $family_member_id)
            ->latest()
            ->paginate(5);

        if ($referrals->isEmpty())
        {
            return ApiResponse::successResponse(
                'No referral records found for this family member.',
                201,
            );
        }

        return ApiResponse::successResponse(
            'Family member referrals retrieved successfully.',
            200,
            ReferralResource::collection($referrals)->response()->getData(true),
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReferralRequest $request)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $data = $request->validated();
        $data["doctor_id"] = $doctor->id;

        DB::beginTransaction();
        try
        {
            $referral = Referral::create($data);

            DB::commit();
            return ApiResponse::successResponse(
                'Medical referral has been created successfully and assigned to the specialist.',
                200,
                new ReferralResource($referral), 
            );
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return $this->errorResponse(
                'An error occurred while creating the referral. Please try again later.',
                500
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $this->getAuthenticatedDoctor();
        $referral = Referral::with("feedbackReferral")->find($id);
        if(!$referral)
        {
            return ApiResponse::errorResponse(
                'The requested referral record could not be found.',
                404
            );
        }

        return ApiResponse::successResponse(
            'Referral details retrieved successfully.',
            200,
            new ReferralResource($referral),
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $this->getAuthenticatedDoctor();
        $referral = Referral::find($id);
        if(!$referral)
        {
            return ApiResponse::errorResponse(
                'The requested referral record could not be found.',
                404
            );
        }

        return ApiResponse::successResponse(
            'Referral details retrieved successfully.',
            200,
            new ReferralResource($referral),
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReferralRequest $request, $id)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $data = $request->validated();
        $data["doctor_id"] = $doctor->id;

        $referral = Referral::find($id);
        if (!$referral)
        {
            return ApiResponse::errorResponse('The requested referral record could not be found.', 404);
        }

        DB::beginTransaction();
        try
        {
            $referral->update($data);
            
            DB::commit();
            return ApiResponse::successResponse(
                'Medical referral has been updated successfully.',
                200,
                new ReferralResource($referral),
            );
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return ApiResponse::errorResponse(
                'An error occurred while updating the referral. Please try again later.',
                500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->getAuthenticatedDoctor();
        $referral = Referral::with('feedbackReferral')->find($id);
        if (!$referral)
        {
            return ApiResponse::errorResponse('The requested referral record could not be found.', 404);
        }

        if ($referral->result()->exists())
        {
            return ApiResponse::errorResponse(
                'Cannot delete this referral because a specialist response has already been received.', 
                422
            );
        }

        DB::beginTransaction();
        try
        {
            $referral->delete();
            
            DB::commit();
            return ApiResponse::successResponse(
                'Medical referral has been deleted successfully.',
                200,
                // null,
            );
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return ApiResponse::errorResponse(
                'An error occurred while deleting the referral. Please try again later.',
                500
            );
        }
    }
}
