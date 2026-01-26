<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\AssignDoctorsToFamilyRequest;
use App\Http\Requests\Doctor\DeathRecordsStoreRequest;
use App\Http\Requests\Doctor\FamilyStoreRequest;
use App\Http\Requests\Doctor\FamilyUpdateRequest;
use App\Http\Requests\Doctor\MemberUpdateRequest;
use App\Http\Requests\Doctor\HousingInfoStoreRequest;
use App\Http\Requests\Doctor\MedicalHistoryStoreRequest;
use App\Http\Requests\Doctor\MemberStoreRequest;
use App\Http\Requests\Doctor\SocialResearchStoreRequest;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\FamilyBasicResource;
use App\Http\Resources\FamilyShowResource;
use App\Http\Resources\IndexFamilyResource;
use App\Models\DeathRecord;
use App\Models\Doctor;
use App\Models\Family;
use App\Models\FamilyMember;
use App\Traits\HasDoctorContext;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FamilyController extends Controller
{
    use HasDoctorContext;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->userable_type !== \App\Models\Doctor::class)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access. Your account type does not have the required permissions.'
            ], 403);
        }

        $families = Family::with("headOfFamily")->paginate();
        if ($families->isEmpty())
        {
            return response()->json([
                'status' => 'success',
                'message' => 'No families found at the moment.',
                'data' => []
            ], 200);
        }

        return IndexFamilyResource::collection($families)->additional([
            'status' => 'success'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FamilyStoreRequest $request)
    {
        if (Auth::user()->userable_type !== \App\Models\Doctor::class)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access. Your account type does not have the required permissions.'
            ], 403);
        }

        $data = $request->validated();
        // return response()->json([
        //     'status' => 'success',
        //     'message' => 'Families retrieved successfully.',
        //     'data' => $data
        // ], 200);

        $family = Family::create($data);
        return response()->json([
            'status' => 'success',
            'message' => 'Families retrieved successfully.',
            'family_id' => $family->id
            // 'data' => $data
        ], 200);
    }

    public function storeMembers(MemberStoreRequest $request, $family_id)
    {
        $data = $request->validated()['members'];
        $user = $this->getAuthenticatedDoctor();
        // $user = Auth::user();
        if (Auth::user()->userable_type !== \App\Models\Doctor::class)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access. Your account type does not have the required permissions.'
            ], 403);
        }

        // $request->merge(['family_id' => $family_id]);
        $family = Family::find($family_id);
        if(!$family)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Family not found.'
            ], 404);
        }

        DB::beginTransaction();
        try
        {
            // $family->members()->createMany($data);
            foreach ($data as $memberData)
            {
                $memberId = $memberData['id'] ?? null;
                $family->members()->updateOrCreate(
        [
                        'full_name' => $memberData['full_name'],
                        'birth_date' => $memberData['birth_date'],
                    ],
            [
                        'is_male' => $memberData['is_male'],
                        'relationship_to_head' => $memberData['relationship_to_head'],
                        'insurance_type' => $memberData['insurance_type'] ?? null,
                        'notes' => $memberData['notes'] ?? null,
                    ]
                );
            }
            $doctors = Doctor::where("health_unit_id" , $user->health_unit_id)
                ->whereIn('specialization', ['dentist', 'family'])
                ->where('id', '!=', $user->id)
                ->get();

            $grouped = $doctors->groupBy('specialization');

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Members added successfully.',
                'family_id' => $family->id,
                'data' => [
                    'family_doctors' => DoctorResource::collection($grouped->get('family', [])),
                    'dentists' => DoctorResource::collection($grouped->get('dentist', []))
                ]
            ], 200);
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to complete the members registration step. Please verify the entered data' . $e->getMessage(),
                'family_id' => $family->id
            ], 500);
        }
    }

    public function assignDoctors(AssignDoctorsToFamilyRequest $request, $family_id)
    {
        $data = $request->validated();
        $user = $this->getAuthenticatedDoctor();
        $family = Family::find($family_id);
        if(!$family)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Family not found.'
            ], 404);
        }

        $doctors = Doctor::whereIn('id', [$data['family_doctor_id'], $data['dentist_id']])->get();
        $familyDoctor = $doctors->where('id', $data['family_doctor_id'])
            ->where('specialization', 'family')
            ->first();

        $dentistDoctor = $doctors->where('id', $data['dentist_id'])
            ->where('specialization', 'dentist')
            ->first();

        if (!$familyDoctor || !$dentistDoctor)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed: One or both doctors are missing or have incorrect specializations.',
                'family_id' => $family->id,
            ], 422);
        }

        DB::beginTransaction();
        try
        {
            $family->update([
                'family_doctor_id' => $data['family_doctor_id'],
                'family_doctor_assign_date' => $data['family_doctor_date'],
                'dentist_id' => $data['dentist_id'],
                'dentist_assign_date' => $data['dentist_date'],
            ]);

            $members = $family->members()->select('id', 'full_name')->get();
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'The selected doctors have been successfully assigned to the family.',
                'data' => [
                    'family_id' => $family->id,
                    'family doctor' => $family->familyDoctor->user->name ?? 'Assigned',
                    'dentist' => $family->dentistDoctor->user->name ?? 'Assigned',
                    "family members" => $members
                ]
            ], 200);
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to assign doctors. Please try again.',
                'family_id' => $family->id,
            ], 500);
        }
    }

    public function storeMedicalHistory(MedicalHistoryStoreRequest $request, $family_id)
    {
        $validatedData = $request->validated();
        $data = $validatedData['medical_histories'] ?? [];
        $user = $this->getAuthenticatedDoctor();
        $family = Family::find($family_id);
        if(!$family)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Family not found.'
            ], 404);
        }

        $familyMemberIds = $family->members()->pluck('id')->toArray(); // IDs الأفراد بتوع العيلة دي بس
        foreach ($data as $history) 
        {
            if (!in_array($history['family_member_id'], $familyMemberIds))
            {
                return response()->json([
                    'status' => 'error',
                    'message' => "The member ID {$history['family_member_id']} does not belong to this family."
                ], 422);
            }
        }

        DB::beginTransaction();
        try
        {
            // if ($request->has('medical_histories'))
            // {
            foreach ($data as $history)
            {
                $member = FamilyMember::find($history['family_member_id']);
                if ($member)
                {
                    $member->medicalHistories()->updateOrCreate(
            ['id' => $history['id'] ?? null], 
                [
                            'discovery_date' => $history['discovery_date'],
                            'disease_type' => $history['disease_type'],
                            'type_of_illness' => $history['type_of_illness'],
                            'note' => $history['note'] ?? null,
                        ]
                    );
                }
            }

            $familyMembers = $family->members()->select('id', 'full_name')->get();
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Medical histories recorded successfully.',
                'family_id' => $family->id,
                'family members' => $familyMembers,
                // الخطوة الجاية: البحث الاجتماعي أو معلومات السكن
                // 'next_step' => 'social research' 
            ], 200);
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to save the medical history records. Please try again later.' . $e->getMessage()
            ], 500);
        }
    }

    public function storeDeathRecords(DeathRecordsStoreRequest $request, $family_id)
    {
        $validatedData = $request->validated();
        $data = $validatedData['death_records'] ?? [];
        $user = $this->getAuthenticatedDoctor();
        $family = Family::find($family_id);
        if(!$family)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Family not found.'
            ], 404);
        }

        $familyMemberIds = $family->familyMembers()->pluck('id')->toArray();
        foreach ($data as $record)
        {
            if (!in_array($record['family_member_id'], $familyMemberIds))
            {
                return response()->json([
                    'status' => 'error',
                    'message' => "Member ID {$record['family_member_id']} does not belong to this family."
                ], 422);
            }
        }

        DB::beginTransaction();
        try
        {
            foreach ($data as $record)
            {
                DeathRecord::updateOrCreate(
        ['family_member_id'=> $record['family_member_id']], // شرط البحث
            [
                        'death_date'=> $record['death_date'],
                        'age_at_death'=> $record['age_at_death'],
                        'cause_of_death'=> $record['cause_of_death'],
                        'death_code'=> $record['death_code'],
                    ]
                );
            }

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Death records have been recorded successfully.',
                'family_id' => $family->id,
            ], 200);
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to finalize the death registry records at this moment.'
            ], 500);
        }
    }

    public function storeHousingInfo(HousingInfoStoreRequest $request, $family_id)
    {
        $data = $request->validated();
        $user = $this->getAuthenticatedDoctor();
        $family = Family::find($family_id);
        if(!$family)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Family not found.'
            ], 404);
        }

        $housing = $family->housingInfo()->updateOrCreate(
    ['family_id' => $family->id],
        $data
        );
        return response()->json([
            'status' => 'success',
            'message' => 'Housing information saved successfully',
            'family_id' => $family->id,
            // 'data' => $housing
        ], 200);
    }

    public function storeSocialResearch(SocialResearchStoreRequest $request, $family_id)
    {
        $data = $request->validated();
        $user = $this->getAuthenticatedDoctor();
        $family = Family::find($family_id);
        if(!$family)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Family not found.'
            ], 404);
        }

        $socialResearch = $family->socialResearch()->updateOrCreate(
['family_id' => $family->id],
    $data
        );
        
        return response()->json([
            'status' => 'success',
            'message' => 'Social research records saved. Family profile has been successfully created and finalized.',
            // 'data' => $socialResearch
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $family = Family::with([
            'familyMembers', 
            'familyDoctor', 
            'dentistDoctor', 
            'socialResearch', 
            'housingInfo'
        ])->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => new FamilyShowResource($family)
        ]);
    }

    public function edit($family_id)
    {
        $user = $this->getAuthenticatedDoctor();
        $family = Family::find($family_id);
        if(!$family)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Family not found.'
            ], 404);
        }
        
        return response()->json([
            'status' => 'success',
            'message' => 'Family details retrieved successfully for editing.',
            'data'    => new FamilyBasicResource($family),
        ], 200);
    }

    public function editMembers($family_id)
    {
        $user = $this->getAuthenticatedDoctor();
        $family = Family::find($family_id);
        if(!$family)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Family not found.'
            ], 404);
        }

        $members = $family->familyMembers;
        return response()->json([
            'status' => 'success',
            'message' => 'Family members retrieved successfully for mass editing.',
            'data' => [
                'family_id' => $family->id,
                'members'   => $members
            ]
        ], 200);
    }

    public function editAssignDoctors($family_id)
    {
        $user = $this->getAuthenticatedDoctor();
        $family = Family::with(['familyDoctor.user', 'dentistDoctor.user'])->find($family_id);

        if(!$family)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Family not found.'
            ], 404);
        }
        
        $availableDoctors = Doctor::with('user')
            ->where('health_unit_id', $user->health_unit_id)
            ->whereIn('specialization', ['family', 'dentist'])
            ->get()
            ->groupBy('specialization');

        return response()->json([
            'status' => 'success',
            'message' => 'Current assignments and available doctors retrieved successfully.',
            'data' => [
                'family_id' => $family->id,
                'current_assignments' => [
                    'family_doctor_id' => $family->family_doctor_id,
                    'family_doctor_name' => $family->familyDoctor->user->name ?? null,
                    'family_doctor_date' => $family->family_doctor_assign_date,
                    'dentist_id' => $family->dentist_id,
                    'dentist_name' => $family->dentistDoctor->user->name ?? null,
                    'dentist_date' => $family->dentist_assign_date,
                ],
                'available_options' => [
                    'family_doctors' => DoctorResource::collection($availableDoctors->get('family', [])),
                    'dentists' => DoctorResource::collection($availableDoctors->get('dentist', [])),
                ]
            ]
        ], 200);
    }

    public function editMedicalHistory($family_id)
    {
        $user = $this->getAuthenticatedDoctor();
        $family = Family::find($family_id);
        if(!$family)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Family not found.'
            ], 404);
        }

        $membersWithHistory = $family->members->map(function ($member) {
            return [
                'member_id' => $member->id,
                'full_name' => $member->full_name,
                'birth_date' => $member->birth_date,
                'histories' => $member->medicalHistories
            ];
        });

        return response()->json([
            'status' => 'success',
            "message" => "Family members and their medical history records have been retrieved successfully.",
            'data' => [
                'family_id' => $family->id,
                "membersWithHistory" => $membersWithHistory
            ]
        ], 200);
    }

    public function editDeathRecords($family_id)
    {
        $user = $this->getAuthenticatedDoctor();
        $family = Family::find($family_id);
        if(!$family)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Family not found.'
            ], 404);
        }

        $records = $family->members->filter(function($member) {
            return $member->deathRecord !== null;
        })->map(function ($member) {
            return [
                'family_member_id' => $member->id,
                'full_name'        => $member->full_name,
                'death_date'       => $member->deathRecord->death_date,
                'age_at_death'     => $member->deathRecord->age_at_death,
                'cause_of_death'   => $member->deathRecord->cause_of_death,
                'death_code'       => $member->deathRecord->death_code,
            ];
        })->values();

        return response()->json([
            'status' => 'success',
            'message' => 'Death records retrieved successfully.',
            'family_id' => $family->id,
            'data' => [
                'family_id' => $family->id,
                "records" => $records
            ]
        ], 200);
    }

    public function editHousingInfo($family_id)
    {
        $user = $this->getAuthenticatedDoctor();
        $family = Family::find($family_id);
        if(!$family)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Family not found.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Housing information retrieved successfully.',
            'data' => [
                'family_id' => $family->id,
                "housingInfo" => $family->housingInfo
            ]
        ], 200);
    }

    public function editSocialResearch($family_id)
    {
        $user = $this->getAuthenticatedDoctor();
        $family = Family::find($family_id);
        if(!$family)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Family not found.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Social research records retrieved successfully.',
            'data' => [
                'family_id' => $family->id,
                "socialResearch" => $family->socialResearch
            ]
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(FamilyUpdateRequest $request, $family_id)
    {
        $data = $request->validated();
        $user = $this->getAuthenticatedDoctor();
        $family = Family::find($family_id);
        if(!$family)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Family not found.'
            ], 404);
        }

        $family->update($data);
        return response()->json([
            'status' => 'success',
            'message' => 'The family profile was updated without any issues.',
        ], 200);
    }

    public function updateMembers(MemberUpdateRequest $request, $family_id)
    {
        $data = $request->validated()['members'];
        $user = $this->getAuthenticatedDoctor();
        $family = Family::find($family_id);
        if(!$family)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Family not found.'
            ], 404);
        }

        DB::beginTransaction();
        try
        {
            foreach ($data as $memberData)
            {
                $updated = $family->familyMembers()
                    ->where('id', $memberData['id'])
                    ->update($memberData);

                if ($updated === 0)
                {
                    throw new \Exception("Member {$memberData['full_name']} does not belong to this family.");
                }
            }

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'All family members have been successfully verified and updated.',
            ], 200);
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => "We couldn't update the family members' information at this time. Please check the data and try again."
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
