<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\Hypertension\Step1Request;
use App\Http\Requests\Doctor\Hypertension\Step2Request;
use App\Http\Requests\Doctor\Hypertension\Step3Request;
use App\Http\Requests\Doctor\Hypertension\Step4Request;
use App\Models\FamilyMember;
use App\Models\HypertensionFollowUp;
use App\Traits\HasDoctorContext;
use Illuminate\Http\Request;

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
                'status'  => false,
                'message' => 'The specified family member does not exist.'
            ], 404);
        }

        // $alreadyExists = HypertensionFollowUp::where('family_member_id', $data["family_member_id"])->exists();
        // if ($alreadyExists)
        // {
        //     return response()->json([
        //         'status'  => "error",
        //         'message' => 'A hypertension follow-up record already exists for this family member. Multiple records are not allowed.'
        //     ], 400); // 400 تعني Bad Request لأن الطلب خالف منطق العمل
        // }

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
        $followUp = HypertensionFollowUp::find($data["id"]);
        if (!$followUp)
        {
            return response()->json([
                'status'  => false,
                'message' => 'Process Error: Hypertension record not found. Please complete Step 1 first.'
            ], 404);
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
        $followUp = HypertensionFollowUp::find($data["id"]);
        if (!$followUp)
        {
            return response()->json([
                'status'  => false,
                'message' => 'Process Error: Follow-up record not found. Please complete previous steps.'
            ], 404);
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
        $followUp = HypertensionFollowUp::find($data["id"]);
        if (!$followUp)
        {
            return response()->json([
                'status'  => false,
                'message' => 'Process Error: Follow-up record not found. Please complete previous steps.'
            ], 404);
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
        $followUp = HypertensionFollowUp::find($id);
        if (!$followUp)
        {
            return response()->json([
                'status' => false,
                'message' => 'The clinical follow-up record for hypertension could not be located. Please ensure the assessment was initiated in Step 1.'
            ], 404);
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
