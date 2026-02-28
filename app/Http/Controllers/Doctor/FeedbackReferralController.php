<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StoreFeedbackRequest;
use App\Http\Requests\Doctor\UpdateFeedbackRequest;
use App\Http\Resources\FeedbackReferralResource;
use App\Models\FeedbackReferral;
use App\Models\Referral;
use App\Traits\ApiResponse;
use App\Traits\HasDoctorContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeedbackReferralController extends Controller
{
    use HasDoctorContext;
    use ApiResponse;

    /**
     * تخزين رد جديد على إحالة موجودة
     */
    public function store(StoreFeedbackRequest $request)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $data = $request->validated();
        $data["doctor_id"] = $doctor->id;

        $referral = Referral::find($data['referral_id']);
        if ($referral->feedbackReferral()->exists())
        {
            return ApiResponse::errorResponse('This referral already has a feedback recorded.', 422);
        }

        DB::beginTransaction();
        try
        {
            $feedback = FeedbackReferral::create($data);

            DB::commit();
            return ApiResponse::successResponse(
                'Feedback has been recorded successfully.',
                200,
                new FeedbackReferralResource($feedback),
            );
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return ApiResponse::errorResponse(
                'An error occurred while saving feedback. Please try again.',
                500
            );
        }
    }

    /**
     * عرض بيانات رد معين
     */
    public function show($id)
    {
        $this->getAuthenticatedDoctor();
        $feedback = FeedbackReferral::with('referral')->find($id);
        if (!$feedback)
        {
            return ApiResponse::errorResponse('Feedback record not found.', 404);
        }

        return ApiResponse::successResponse(
            'Feedback details retrieved successfully.',
            200,
            new FeedbackReferralResource($feedback),
        );
    }
    
    /**
     * عرض بيانات رد معين للتعديل
     */
    public function edit($id)
    {
        $this->getAuthenticatedDoctor();
        $feedback = FeedbackReferral::with('referral')->find($id);
        if (!$feedback)
        {
            return ApiResponse::errorResponse('Feedback record not found.', 404);
        }

        return ApiResponse::successResponse(
            'Feedback details retrieved successfully.',
            200,
            new FeedbackReferralResource($feedback),
        );
    }

    /**
     * تحديث الرد
     */
    public function update(UpdateFeedbackRequest $request, $id)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $data = $request->validated();
        $data["doctor_id"] = $doctor->id;

        $feedback = FeedbackReferral::find($id);
        if (!$feedback)
        {
            return ApiResponse::errorResponse('Feedback record not found.', 404);
        }

        DB::beginTransaction();
        try
        {
            $feedback->update($data);
            DB::commit();

            return ApiResponse::successResponse(
                'Feedback updated successfully.',
                200,
                new FeedbackReferralResource($feedback),
            );
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return ApiResponse::errorResponse('Error updating feedback.', 500);
        }
    }

    // /**
    //  * حذف الرد
    //  */
    // public function destroy($id)
    // {
    //     $doctor = $this->getAuthenticatedDoctor();
    //     $feedback = FeedbackReferral::find($id);

    //     if (!$feedback) {
    //         return ApiResponse::errorResponse('Feedback record not found.', 404);
    //     }

    //     if ($feedback->doctor_id !== $doctor->id) {
    //         return ApiResponse::errorResponse('Unauthorized to delete this feedback.', 403);
    //     }

    //     $feedback->delete();
    //     return ApiResponse::successResponse('Feedback deleted successfully.', 200);
    // }
}
