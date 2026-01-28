<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StoreSignificantDataRequest;
use App\Http\Requests\UpdateSignificantDataRequest;
use App\Http\Resources\SignificantDataResource;
use App\Models\FamilyMember;
use App\Models\SignificantData;
use App\Traits\HasDoctorContext;
use Illuminate\Http\Request;

class SignificantDataController extends Controller
{
    use HasDoctorContext;

    /**
     * Display a listing of the resource.
     */
    public function index($family_member_id)
    {
        $user = $this->getAuthenticatedDoctor();
        $member = FamilyMember::find($family_member_id);
        if (!$member)
        {
            return response()->json([
                'status'  => false,
                'message' => 'The specified family member does not exist.'
            ], 404);
        }

        // $significant = $member->significantData();
        $significantRecords = $member->significantData()
            ->with(['doctor.user'])
            ->latest('record_date')
            ->paginate();

        return response()->json([
            'status' => true,
            'data'   => [
                "member" => $member,
                "significantRecords" => SignificantDataResource::collection($significantRecords)->response()->getData(true)
                // "significantRecords" =>$significantRecords
            ]
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSignificantDataRequest $request, $family_member_id)
    {
        $data = $request->validated();
        $doctor = $this->getAuthenticatedDoctor();
        $member = FamilyMember::find($family_member_id);
        if (!$member)
        {
            return response()->json([
                'status'  => false,
                'message' => 'The specified family member does not exist.'
            ], 404);
        }

        $significantData = SignificantData::create([
            'doctor_id' => $doctor->id,
            'family_member_id' => $family_member_id,
            'record_date' => $data["record_date"],
            'case_description' => $data["case_description"],
            "action_doctor_name" => $data["action_doctor_name"],
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Significant medical event recorded successfully.',
            'data' => $significantData
        ], 201);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $record = SignificantData::with('doctor.user')->find($id);
        if (!$record)
        {
            return response()->json([
                'status' => false,
                'message' => 'Medical record not found.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => [
                'record_date' => $record->record_date,
                'case_description' => $record->case_description,
                'action_doctor_name' => $record->action_doctor_name,
                "doctor_name" => $record->doctor?->user?->name
            ]
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSignificantDataRequest $request, $id)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $data = $request->validated();
        $record = SignificantData::find($id);
        if (!$record)
        {
            return response()->json([
                'status' => false,
                'message' => 'Medical record not found.'
            ], 404);
        }

        $record->update(array_merge($data, [
            'doctor_id' => $doctor->id
        ]));

        return response()->json([
            'status' => true,
            'message' => 'Updated successfully',
            'data' => $record->only(['record_date', 'case_description', 'action_doctor_name'])
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $record = SignificantData::find($id);
        if (!$record)
        {
            return response()->json([
                'status' => false,
                'message' => 'Medical record not found.'
            ], 404);
        }

        $record->delete();
        return response()->json([
            'status' => true,
            'message' => 'The medical record has been permanently removed from the family member history.',
        ]);
    }
}
