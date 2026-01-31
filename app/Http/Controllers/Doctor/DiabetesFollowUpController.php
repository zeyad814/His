<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\Diabetes\StoreStep1Request;
use App\Http\Requests\Doctor\Diabetes\StoreStep2Request;
use App\Http\Requests\Doctor\Diabetes\StoreStep3Request;
use App\Http\Requests\Doctor\Diabetes\StoreStep4Request;
use App\Http\Requests\Doctor\Diabetes\UpdateStep1Request;
use App\Models\DiabetesFollowUp;
use App\Models\FamilyMember;
use App\Models\Visit;
use App\Traits\HasDoctorContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiabetesFollowUpController extends Controller
{
    use HasDoctorContext;

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
    public function storeStep1(StoreStep1Request $request)
    {
        $data = $request->validated();
        $doctor = $this->getAuthenticatedDoctor();
        $member = FamilyMember::find($data["family_member_id"]);
        if (!$member)
        {
            return response()->json([
                'status'  => "error",
                'message' => 'The specified family member does not exist.'
            ], 404);
        }

        $message = null;
        $visit = Visit::find($data["visit_id"]);
        if (!$visit)
        {
            $message = 'Visit record not found.';
        }
        else if ($visit->visit_type !== 'أمراض مزمنة')
        {
            $message = 'Diabetes follow-up is only permitted for visits categorized as "أمراض مزمنة".';
        }
        else if ($visit->family_member_id != $data['family_member_id'])
        {
            $message = "Data Mismatch: This visit record does not belong to the selected patient.";
        }

        if ($message)
        {
            return response()->json([
                'status'  => "error",
                'message' => $message
            ], 400);
        }

        $data['doctor_id'] = $doctor->id;
        try
        {
            $followUp = DiabetesFollowUp::create($data);

            return response()->json([
                'status'  => "success",
                'message' => 'Step 1: Clinical assessment and vital signs recorded successfully.',
                'data'    => [
                    'id' => $followUp->id
                ]
            ], 201);

        }
        catch (\Exception $e)
        {
            return response()->json([
                'status'  => "error",
                'message' => 'System Error: Failed to initiate diabetes record in Step 1.',
                // 'error'   => $e->getMessage() // Remember to hide this in production for security!
            ], 500);
        }
    }

    public function storeStep2(StoreStep2Request $request)
    {
        $data = $request->validated();
        $doctor = $this->getAuthenticatedDoctor();

        // نستخدم find بدل findOrFail عشان نتحكم في الرسالة الـ Custom
        $followUp = DiabetesFollowUp::with('visit')->find($data["id"]);
        if (!$followUp)
        {
            return response()->json([
                'status'  => "error",
                'message' => 'Record not found. Please ensure that Step 1 (Basic Data) is completed before proceeding.'
            ], 404);
        }

        // التحقق من نوع الزيارة لضمان أمان البيانات
        if (!$followUp->visit || $followUp->visit->visit_type !== 'أمراض مزمنة')
        {
            return response()->json([
                'status'  => "error",
                'message' => 'Unauthorized Action: This record does not belong to a chronic disease visit and cannot be updated.'
            ], 403);
        }

        try
        {
            $followUp->update($data);

            return response()->json([
                'status'  => "success",
                'message' => 'Step 2: Risk factors and complications have been recorded successfully.',
                'data'    => [
                    'id' => $followUp->id
                ]
            ], 200);

        }
        catch (\Exception $e)
        {
            return response()->json([
                'status'  => "error",
                'message' => 'System Error: An unexpected error occurred while saving clinical data. Please try again.'
            ], 500);
        }
    }

    public function storeStep3(StoreStep3Request $request)
    {
        $data = $request->validated();
        $doctor = $this->getAuthenticatedDoctor();
        $followUp = DiabetesFollowUp::with('visit')->find($data["id"]);
        if (!$followUp)
        {
            return response()->json([
                'status'  => "error",
                'message' => 'Record not found. Please complete the previous steps before recording lab results.'
            ], 404);
        }

        if (!$followUp->visit || $followUp->visit->visit_type !== 'أمراض مزمنة')
        {
            return response()->json([
                'status'  => "error",
                'message' => 'Access Denied: This record is not linked to a chronic disease visit.'
            ], 403);
        }

        try
        {
            // تحديث حقول الـ Workup الثلاثة
            $followUp->update($data);

            return response()->json([
                'status'  => "success",
                'message' => 'Step 3: Diagnostic tests and lab workup have been updated successfully.',
                'data'    => [
                    'id' => $followUp->id
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => "error",
                'message' => 'System Error: Failed to save lab results. Please contact system administrator.'
            ], 500);
        }
    }

    public function storeStep4(StoreStep4Request $request)
    {
        $data = $request->validated();
        $doctor = $this->getAuthenticatedDoctor();
        $followUp = DiabetesFollowUp::with('visit')->find($data["id"]);
        if (!$followUp)
        {
            return response()->json([
                'status'  => "error",
                'message' => 'Record not found. Please complete the initial steps before finalizing the treatment plan.'
            ], 404);
        }

        if (!$followUp->visit || $followUp->visit->visit_type !== 'أمراض مزمنة')
        {
            return response()->json([
                'status'  => "error",
                'message' => 'Access Denied: This record does not belong to a chronic disease follow-up.'
            ], 403);
        }

        try
        {
            $followUp->update($data);

            return response()->json([
                'status'  => "success",
                'message' => 'Step 4: Health education and treatment plan saved successfully. Follow-up record is now complete.',
                'data'    => [
                    'id' => $followUp->id
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => "error",
                'message' => 'System Error: Failed to save final treatment data. Please try again.'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $followUp = DiabetesFollowUp::with('visit')->find($id);
        if (!$followUp)
        {
            return response()->json([
                'status' => "error",
                'message' => 'The diabetes follow-up record could not be found. Please ensure the assessment was properly initiated.'
            ], 404);
        }

        if (!$followUp->visit || $followUp->visit->visit_type !== 'أمراض مزمنة')
        {
            return response()->json([
                'status'  => "error",
                'message' => 'Access Denied: This record is not associated with a valid chronic disease visit.'
            ], 403);
        }

        $member = $followUp->familyMember()->first();
        $attendingDoctor = $followUp->doctor()->with('user')->first();

        return response()->json([
            'status' => "success",
            'message' => 'Diabetes record retrieved successfully.',
            'data' => [
                "member" => $member,
                "follow_up" => $followUp->unsetRelations(),
                "doctor_name" => $attendingDoctor->user->name
            ]
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editStep1($id)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $followUp = DiabetesFollowUp::with("visit")->find($id);
        if (!$followUp)
        {
            return response()->json([
                'status' => "error",
                'message' => 'The specified diabetes record does not exist.'
            ], 404);
        }

        if (!$followUp->visit || $followUp->visit->visit_type !== 'أمراض مزمنة')
        {
            return response()->json([
                'status' => "error",
                'message' => 'Invalid Access: This record is not linked to an "أمراض مزمنة" visit.'
            ], 403);
        }

        return response()->json([
            'status' => "success",
            'message' => 'Data retrieved successfully for Step 1.',
            'data' => [
                'id' => $followUp->id,
                // 'family_member_id' => $followUp->family_member_id,
                // 'visit_id' => $followUp->visit_id,
                'date' => $followUp->date,
                'chief_complaint' => $followUp->chief_complaint,
            ]
        ], 200);
    }

    public function editStep2($id)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $followUp = DiabetesFollowUp::with('visit')->find($id);
        if (!$followUp)
        {
            return response()->json([
                'status' => "error",
                'message' => 'The specified diabetes record does not exist.'
            ], 404);
        }

        if (!$followUp->visit || $followUp->visit->visit_type !== 'أمراض مزمنة')
        {
            return response()->json([
                'status' => "error",
                'message' => 'Invalid Access: This record is not classified as "أمراض مزمنة".'
            ], 403);
        }

        return response()->json([
            'status' => "success",
            'message' => 'Data retrieved successfully for Step 2.',
            'data' => [
                'id' => $followUp->id,
                'risk_factors' => $followUp->risk_factors,
                'complications' => $followUp->complications,
            ]
        ], 200);
    }

    public function editStep3($id)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $followUp = DiabetesFollowUp::with('visit')->find($id);
        if (!$followUp)
        {
            return response()->json([
                'status' => "error",
                'message' => 'The specified diabetes record does not exist.'
            ], 404);
        }

        if (!$followUp->visit || $followUp->visit->visit_type !== 'أمراض مزمنة')
        {
            return response()->json([
                'status' => "error",
                'message' => 'Invalid Access: This record is not classified as "أمراض مزمنة".'
            ], 403);
        }

        return response()->json([
            'status' => "success",
            'message' => 'Data retrieved successfully for Step 3.',
            'data' => [
                'id' => $followUp->id,
                'workup_every_visit' => $followUp->workup_every_visit,
                'workup_6_month' => $followUp->workup_6_month,
                'workup_annual' => $followUp->workup_annual,
            ]
        ], 200);
    }

    public function editStep4($id)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $followUp = DiabetesFollowUp::with('visit')->find($id);
        if (!$followUp)
        {
            return response()->json([
                'status' => "error",
                'message' => 'The specified diabetes record does not exist.'
            ], 404);
        }

        if (!$followUp->visit || $followUp->visit->visit_type !== 'أمراض مزمنة')
        {
            return response()->json([
                'status' => "error",
                'message' => 'Invalid Access: This record is not classified as "أمراض مزمنة".'
            ], 403);
        }

        return response()->json([
            'status' => "success",
            'message' => 'Data retrieved successfully for Step 4.',
            'data' => [
                'id' => $followUp->id,
                'health_education' => $followUp->health_education,
                'referrals' => $followUp->referrals,
                'treatment_plan' => $followUp->treatment_plan,
            ]
        ], 200);
    }

    /**
     * Update Step 1: Clinical assessment and basic data for Diabetes.
     */
    public function updateStep1(UpdateStep1Request $request, $id)
    {
        $data = $request->validated();
        $doctor = $this->getAuthenticatedDoctor();
        $followUp = DiabetesFollowUp::find($id);
        if (!$followUp)
        {
            return response()->json([
                'status'  => "error",
                'message' => 'The specified diabetes record does not exist.'
            ], 404);
        }

        if (!$followUp->visit || $followUp->visit->visit_type !== 'أمراض مزمنة')
        {
            return response()->json([
                'status'  => "error",
                'message' => 'Invalid Access: This record is not linked to a valid "Chronic Disease" visit.'
            ], 403);
        }

        try
        {
            $followUp->update($data);

            return response()->json([
                'status'  => "success",
                'message' => 'Step 1: Diabetes clinical assessment updated successfully.',
                'data'    => [
                    'id' => $followUp->id
                ]
            ], 200);

        }
        catch (\Exception $e)
        {
            return response()->json([
                'status'  => "error",
                'message' => 'System Error: An unexpected error occurred while updating the diabetes record.',
                // 'error' => $e->getMessage() // للتصحيح فقط
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $followUp = DiabetesFollowUp::with('visit')->find($id);
        if (!$followUp)
        {
            return response()->json([
                'status'  => "error",
                'message' => 'The specified diabetes follow-up record does not exist.'
            ], 404);
        }

        if (!$followUp->visit || $followUp->visit->visit_type !== 'أمراض مزمنة')
        {
            return response()->json([
                'status'  => "error",
                'message' => 'Invalid Access: This record is not classified as a chronic disease follow-up.'
            ], 403);
        }

        DB::beginTransaction();
        try
        {
            $associatedVisit = $followUp->visit;
            $followUp->delete();
            $associatedVisit->delete();
            // if ($associatedVisit)
            // {
            //     $associatedVisit->delete();
            // }

            DB::commit();
            return response()->json([
                'status'  => "success",
                'message' => 'The diabetes record and its associated visit have been successfully deleted.'
            ], 200);

        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return response()->json([
                'status'  => "error",
                'message' => 'System Error: Unable to complete the deletion process. Please try again later.'
            ], 500);
        }
    }
}
