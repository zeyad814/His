<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\CvRiskAssessment\StoreStep1Request;
use App\Http\Requests\Doctor\CvRiskAssessment\StoreStep2Request;
use App\Http\Requests\Doctor\CvRiskAssessment\StoreStep3Request;
use App\Http\Resources\CvRiskAssessmentResource;
use App\Models\CvRiskAssessment;
use App\Models\FamilyMember;
use App\Traits\ApiResponse;
use App\Traits\HasDoctorContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CvRiskAssessmentController extends Controller
{
    use HasDoctorContext;
    use ApiResponse;
    
    /**
     * Display a listing of assessments for a specific family member.
    */
    public function index($family_member_id)
    {
        $this->getAuthenticatedDoctor();
        $member = FamilyMember::find($family_member_id);
        if(!$member)
        {
            return ApiResponse::errorResponse(
                'The requested family member record was not found.', 
                404
            );
        }
        // بنجيب كل التقييمات الخاصة بالمريض ده
        $assessments = CvRiskAssessment::with('doctor')
            ->where('family_member_id', $family_member_id)
            ->latest()
            ->paginate(5);

        if ($assessments->isEmpty())
        {
            return ApiResponse::successResponse(
                'No assessments found for this family member.',
                200,
                $assessments
            );
        }

        $resourceCollection = CvRiskAssessmentResource::collection($assessments)->response()->getData(true);

        return ApiResponse::successResponse(
            'Assessments list retrieved successfully.',
            200,
            $resourceCollection
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeStep1(StoreStep1Request $request)
    {
        $data = $request->validated();
        $doctor = $this->getAuthenticatedDoctor();
        $data["doctor_id"] = $doctor->id;

        DB::beginTransaction();
        try
        {
            $cvRiskAssessment = CvRiskAssessment::create($data);
            DB::commit();
            return ApiResponse::successResponse(
                'CV risk assessment saved successfully',
                200,
                ['id' => $cvRiskAssessment->id]
            );
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return ApiResponse::errorResponse(
                'Unable to save cv risk assessment. Please check the provided data.',
                500
            );
        }
    }

    public function storeStep2(StoreStep2Request $request, $id)
    {
        $data = $request->validated();
        $this->getAuthenticatedDoctor();

        DB::beginTransaction();
        try
        {
            $cvRiskAssessment = CvRiskAssessment::find($id);
            if (!$cvRiskAssessment)
            {
                return ApiResponse::errorResponse(
                    'No active assessment session found. Please go back to step 1.',
                    404
                );
            }

            $cvRiskAssessment->update($data);

            DB::commit();
            return ApiResponse::successResponse(
                'Step 2: Clinical measurements and laboratory results saved successfully.', 
                200,
                ['id' => $cvRiskAssessment->id]
            );
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return ApiResponse::errorResponse(
                'Technical error while saving measurements. Please try again.',
                500
            );
        }
    }

    public function storeStep3(StoreStep3Request $request, $id)
    {
        $data = $request->validated();
        $this->getAuthenticatedDoctor();

        DB::beginTransaction();
        try
        {
            $cvRiskAssessment = CvRiskAssessment::find($id);
            if (!$cvRiskAssessment)
            {
                return ApiResponse::errorResponse(
                    'Assessment record not found. Finalization failed.',
                    404
                );
            }

            $cvRiskAssessment->update($data);

            DB::commit();
            return ApiResponse::successResponse(
                'Assessment Finalized: The medical plan and risk level have been officially recorded.',
                200,
                ['id' => $cvRiskAssessment->id]
            );
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return ApiResponse::errorResponse(
                'An error occurred while finalizing the assessment.',
                500
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->getAuthenticatedDoctor();

        try
        {
            $assessment = CvRiskAssessment::with(['familyMember', 'doctor'])->find($id);

            if (!$assessment)
            {
                return ApiResponse::errorResponse('Assessment report not found.', 404);
            }

            return ApiResponse::successResponse(
                'Assessment report retrieved successfully.',
                200,
                new CvRiskAssessmentResource($assessment)
            );
        }
        catch (\Exception $e)
        {
            return ApiResponse::errorResponse('Error retrieving the report.', 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editStep1($id)
    {
        $this->getAuthenticatedDoctor();
        $assessment = CvRiskAssessment::find($id);
        if (!$assessment)
        {
            return ApiResponse::errorResponse(
                'Assessment record not found. Please go back to step 1.',
                404
            );
        }

        return ApiResponse::successResponse('Step 1 data retrieved', 200, new CvRiskAssessmentResource($assessment));
    }

    public function editStep2($id)
    {
        $this->getAuthenticatedDoctor();
        $assessment = CvRiskAssessment::find($id);
        if (!$assessment)
        {
            return ApiResponse::errorResponse(
                'Assessment record not found. Please go back to step 1.',
                404
            );
        }

        return ApiResponse::successResponse('Step 2 data retrieved', 200, new CvRiskAssessmentResource($assessment));
    }

    public function editStep3($id)
    {
        $this->getAuthenticatedDoctor();
        $assessment = CvRiskAssessment::find($id);
        if (!$assessment)
        {
            return ApiResponse::errorResponse(
                'Assessment record not found. Please go back to step 1.',
                404
            );
        }

        return ApiResponse::successResponse('Step 3 data retrieved', 200, new CvRiskAssessmentResource($assessment));
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStep1(StoreStep1Request $request, $id)
    {
        $data = $request->validated();
        $this->getAuthenticatedDoctor();

        DB::beginTransaction();
        try
        {
            $cvRiskAssessment = CvRiskAssessment::find($id);
            if (!$cvRiskAssessment)
            {
                return ApiResponse::errorResponse('Assessment record not found.', 404);
            }

            $cvRiskAssessment->update($data);

            DB::commit();
            return ApiResponse::successResponse(
                'Step 1: Risk factors updated successfully.',
                200,
                ['id' => $cvRiskAssessment->id]
            );
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return ApiResponse::errorResponse('Failed to update risk factors.', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->getAuthenticatedDoctor();

        DB::beginTransaction();
        try
        {
            $cvRiskAssessment = CvRiskAssessment::find($id);

            if (!$cvRiskAssessment)
            {
                return ApiResponse::errorResponse(
                    'Assessment record not found or already deleted.',
                    404
                );
            }

            $cvRiskAssessment->delete();

            DB::commit();
            return ApiResponse::successResponse(
                'The cardiovascular risk assessment has been deleted successfully.',
                200
            );
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return ApiResponse::errorResponse(
                'An error occurred while trying to delete the record.',
                500
            );
        }
    }
}
