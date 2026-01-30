<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\Hypertension\Step1Request;
use App\Http\Requests\Doctor\Hypertension\Step2Request;
use App\Http\Requests\Doctor\Hypertension\Step3Request;
use App\Http\Requests\Doctor\Hypertension\Step4Request;
use App\Http\Requests\Doctor\Hypertension\UpdateStep1Request;
use App\Models\FamilyMember;
use App\Models\HypertensionFollowUp;
use App\Models\Visit;
use App\Traits\HasDoctorContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HypertensionStepController extends Controller
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
    public function storeStep1(Step1Request $request)
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
            $message = 'Invalid visit type. Hypertension follow-up can only be recorded for visits categorized as "أمراض مزمنة".';
        }
        else if ($visit->family_member_id != $data['family_member_id'])
        {
            $message = "Data Mismatch: The provided visit ID does not belong to the selected family member.";
        }

        if ($message)
        {
            return response()->json([
                'status'  => false,
                'message' => $message
            ], 400);
        }

        $data['doctor_id'] = $doctor->id;
        try
        {
            $followUp = HypertensionFollowUp::create($data);

            return response()->json([
                'status'  => "success",
                'message' => 'Step 1: Clinical assessment and vital signs saved successfully.',
                'data'    => [
                    'id' => $followUp->id
                ]
            ], 201);

        }
        catch (\Exception $e)
        {
            return response()->json([
                'status'  => "error",
                'message' => 'System Error: Failed to initiate hypertension record in Step 1.',
                // 'error'   => $e->getMessage() // Remember to hide this in production for security!
            ], 500);
        }
    }

    public function storeStep2(Step2Request $request)
    {
        $data = $request->validated();
        $doctor = $this->getAuthenticatedDoctor();
        $followUp = HypertensionFollowUp::with('visit')->find($data["id"]);
        if (!$followUp)
        {
            return response()->json([
                'status'  => "error",
                'message' => 'Process Error: Hypertension record not found. Please complete Step 1 first.'
            ], 404);
        }

        if (!$followUp->visit || $followUp->visit->visit_type !== 'أمراض مزمنة')
        {
            return response()->json([
                'status'  => "error",
                'message' => 'Invalid Access: This record is not classified as "أمراض مزمنة". Update denied.'
            ], 403);
        }

        try
        {
            $followUp->update($data);

            return response()->json([
                'status'  => "success",
                'message' => 'Step 2: Risk factors and complications updated successfully.',
                'data'    => [
                    'id' => $followUp->id
                ]
            ], 201);
        }
        catch (\Exception $e)
        {
            return response()->json([
                'status'  => "error",
                'message' => 'System Error: Failed to update medical data in Step 2.',
                // 'error'   => $e->getMessage() // Remember to hide this in production for security!
            ], 500);
        }
    }

    public function storeStep3(Step3Request $request)
    {
        $data = $request->validated();
        $doctor = $this->getAuthenticatedDoctor();
        $followUp = HypertensionFollowUp::with('visit')->find($data["id"]);
        if (!$followUp)
        {
            return response()->json([
                'status'  => "error",
                'message' => 'Process Error: Follow-up record not found. Please complete previous steps.'
            ], 404);
        }

        if (!$followUp->visit || $followUp->visit->visit_type !== 'أمراض مزمنة')
        {
            return response()->json([
                'status'  => "error",
                'message' => 'Invalid Access: This record is not classified as "أمراض مزمنة". Update denied.'
            ], 403);
        }

        try
        {
            $followUp->update($data);

            return response()->json([
                'status'  => "success",
                'message' => 'Step 3: Lab investigations (Workup) updated successfully.',
                'data'    => [
                    'id' => $followUp->id
                ]
            ], 201);
        }
        catch (\Exception $e)
        {
            return response()->json([
                'status'  => "error",
                'message' => 'System Error: Failed to save lab investigations in Step 3.',
                // 'error'   => $e->getMessage() // Remember to hide this in production for security!
            ], 500);
        }
    }

    public function storeStep4(Step4Request $request)
    {
        $data = $request->validated();
        $doctor = $this->getAuthenticatedDoctor();
        $followUp = HypertensionFollowUp::with('visit')->find($data["id"]);
        if (!$followUp)
        {
            return response()->json([
                'status'  => "error",
                'message' => 'Process Error: Follow-up record not found. Please complete previous steps.'
            ], 404);
        }

        if (!$followUp->visit || $followUp->visit->visit_type !== 'أمراض مزمنة')
        {
            return response()->json([
                'status'  => "error",
                'message' => 'Invalid Access: This record is not classified as "أمراض مزمنة". Update denied.'
            ], 403);
        }

        try
        {
            $followUp->update($data);

            return response()->json([
                'status'  => "success",
                'message' => 'Hypertension follow-up cycle has been successfully completed and finalized.',
                'data'    => [
                    'id' => $followUp->id
                ]
            ], 201);
        }
        catch (\Exception $e)
        {
            return response()->json([
                'status'  => "error",
                'message' => 'System Error: Failed to save the final treatment step.',
                // 'error'   => $e->getMessage() // Remember to hide this in production for security!
            ], 500);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $followUp = HypertensionFollowUp::with('visit')->find($id);
        if (!$followUp)
        {
            return response()->json([
                'status' => "error",
                'message' => 'The clinical follow-up record for hypertension could not be located. Please ensure the assessment was initiated in Step 1.'
            ], 404);
        }

        if (!$followUp->visit || $followUp->visit->visit_type !== 'أمراض مزمنة')
        {
            return response()->json([
                'status'  => "error",
                'message' => 'Security Error: This record is not linked to a valid "Chronic Disease" visit.'
            ], 403);
        }

        $member = $followUp->familyMember;
        $attendingDoctor = $followUp->doctor;

        return response()->json([
            'status' => "success",
            'message' => 'Hypertension record retrieved successfully.',
            'data' => [
                "member" => $member,
                "follow_up" => $followUp,
                'doctor_name' => $attendingDoctor->user->name
            ]
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editStep1($id)
    {
        $followUp = HypertensionFollowUp::with("visit")->find($id);
        if (!$followUp)
        {
            return response()->json([
                'status'  => "error",
                'message' => 'The specified hypertension record does not exist.'
            ], 404);
        }

        if ($followUp->visit->visit_type !== 'أمراض مزمنة')
        {
            return response()->json([
                'status'  => "error",
                'message' => 'Invalid Access: This record is not linked to an "أمراض مزمنة" visit.'
            ], 403);
        }

        return response()->json([
            'status'  => "success",
            'message' => 'Data retrieved successfully for Step 1.',
            'data'    => [
                'id' => $followUp->id,
                // 'family_member_id' => $followUp->family_member_id,
                // 'member_name' => $followUp->familyMember->name, // مفيد للعرض في الـ UI
                // 'visit_id' => $followUp->visit_id,
                'date' => $followUp->date,
                'chief_complaint' => $followUp->chief_complaint,
                'bp' => $followUp->bp, // Systolic & Diastolic
            ]
        ], 200);
    }

    public function editStep2($id)
    {
        $followUp = HypertensionFollowUp::with('visit')->find($id);
        if (!$followUp)
        {
            return response()->json([
                'status'  => "error",
                'message' => 'The specified hypertension record does not exist. Please complete Step 1 first.'
            ], 404);
        }

        if (!$followUp->visit || $followUp->visit->visit_type !== 'أمراض مزمنة') {
            return response()->json([
                'status'  => "error",
                'message' => 'Invalid Access: This record is not classified as "أمراض مزمنة".'
            ], 403);
        }

        // 3. إرجاع البيانات المخصصة للخطوة الثانية
        return response()->json([
            'status'  => "success",
            'message' => 'Data retrieved successfully for Step 2.',
            'data'    => [
                'id' => $followUp->id,
                'risk_factors' => $followUp->risk_factors,
                'complications_and_target_organ_affection' => $followUp->complications_and_target_organ_affection,
            ]
        ], 200);
    }

    public function editStep3($id)
    {
        $followUp = HypertensionFollowUp::with('visit')->find($id);
        if (!$followUp)
        {
            return response()->json([
                'status'  => "error",
                'message' => 'The specified hypertension record does not exist. Please complete Step 1 first.'
            ], 404);
        }

        if (!$followUp->visit || $followUp->visit->visit_type !== 'أمراض مزمنة') {
            return response()->json([
                'status'  => "error",
                'message' => 'Invalid Access: This record is not classified as "أمراض مزمنة".'
            ], 403);
        }

        // 3. إرجاع البيانات المخصصة للخطوة الثانية
        return response()->json([
            'status'  => "success",
            'message' => 'Data retrieved successfully for Step 2.',
            'data'    => [
                'id' => $followUp->id,
                'workup_6_month' => $followUp->workup_6_month,
                'workup_annual' => $followUp->workup_annual,
            ]
        ], 200);
    }

    public function editStep4($id)
    {
        $followUp = HypertensionFollowUp::with('visit')->find($id);
        if (!$followUp)
        {
            return response()->json([
                'status'  => "error",
                'message' => 'The specified hypertension record does not exist. Please complete Step 1 first.'
            ], 404);
        }

        if (!$followUp->visit || $followUp->visit->visit_type !== 'أمراض مزمنة') {
            return response()->json([
                'status'  => "error",
                'message' => 'Invalid Access: This record is not classified as "أمراض مزمنة".'
            ], 403);
        }

        return response()->json([
            'status'  => "success",
            'message' => 'Data retrieved successfully for Step 2.',
            'data'    => [
                'id' => $followUp->id,
                'treatment_plan' => $followUp->treatment_plan,
                'health_education' => $followUp->health_education,
            ]
        ], 200);
    }
    /**
     * Update the specified resource in storage.
     */
    public function updateStep1(UpdateStep1Request $request, $id)
    {
        $data = $request->validated();
        $followUp = HypertensionFollowUp::find($id);
        if (!$followUp)
        {
            return response()->json([
                'status'  => "error",
                'message' => 'The specified hypertension record does not exist.'
            ], 404);
        }

        if ($followUp->visit->visit_type !== 'أمراض مزمنة')
        {
            return response()->json([
                'status'  => "error",
                'message' => 'Invalid Access: This record is not linked to an "أمراض مزمنة" visit.'
            ], 403);
        }

        try
        {
            $followUp->update($data);

            return response()->json([
                'status'  => "success",
                'message' => 'Step 1: Clinical assessment updated successfully.',
                'data'    => ['id' => $followUp->id]
            ], 200);

        }
        catch (\Exception $e)
        {
            return response()->json([
                'status'  => "error",
                'message' => 'System Error: Could not update the record.',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $followUp = HypertensionFollowUp::with('visit')->find($id);
        if (!$followUp)
        {
            return response()->json([
                'status'  => "error",
                'message' => 'The specified hypertension record does not exist.'
            ], 404);
        }

        if (!$followUp->visit || $followUp->visit->visit_type !== 'أمراض مزمنة') {
            return response()->json([
                'status'  => "error",
                'message' => 'Invalid Access: This record is not classified as "أمراض مزمنة".'
            ], 403);
        }

        DB::beginTransaction();
        try
        {
            $associatedVisit = $followUp->visit;
            $followUp->delete();
            $associatedVisit->delete();

            DB::commit();
            return response()->json([
                'status'  => "success",
                'message' => 'Hypertension record and its associated visit have been successfully deleted.'
            ], 200);
        }
        catch (\Exception $e) {
            return response()->json([
                'status'  => "error",
                'message' => "System Error: Unable to complete the deletion process. Please try again later or contact support."
            ], 500);
        }
    }
}
