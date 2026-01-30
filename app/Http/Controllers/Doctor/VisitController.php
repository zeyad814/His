<?php

namespace App\Http\Controllers\Doctor;

use App\Models\Visit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FamilyMember;
use App\Traits\HasDoctorContext;

class VisitController extends Controller
{
    use HasDoctorContext;
    public function store(Request $request)
    {
        $validated = $request->validate([
            'family_member_id' => 'required|exists:family_members,id',

            'date' => 'required|date',
            'visit_type' => 'required|string|in:متابعة الحمل,تنظيم الأسرة,متابعة طفل,أمراض مزمنة,زيارة دورية,أسنان',

            'complaint' => 'required|string',
            'clinical_examination' => 'required|string',

            'investigations' => 'nullable|string',

            'diagnoses' => 'required|string',

            'management_follow_up' => 'required|string',
        ]);

        $doctor = $this->getAuthenticatedDoctor();
        $validated['doctor_id'] = $doctor->id;

        $visit = Visit::create($validated);

        return response()->json([
            'message' => 'Visit created successfully',
            'data' => $visit
        ], 201);
    }

    public function index(FamilyMember $familyMember)
    {
        $visits = $familyMember->visits()->with('doctor')->latest('date')->get();

        return response()->json(['data' => $visits]);
    }

    public function show(FamilyMember $familyMember, Visit $visit)
    {
        if ($visit->family_member_id !== $familyMember->id) {
            return response()->json(['message' => 'Visit not found for this family member'], 404);
        }

        return response()->json(['data' => $visit->load('doctor')]);
    }

    public function edit(FamilyMember $familyMember, Visit $visit)
    {
        if ($visit->family_member_id !== $familyMember->id) {
            return response()->json([
                'message' => 'This visit does not belong to the specified family member.'
            ], 403);
        }

        return response()->json([
            'data' => $visit->load('doctor')
        ]);
    }


    public function update(Request $request, FamilyMember $familyMember, Visit $visit)
    {
        if ($visit->family_member_id !== $familyMember->id) {
            return response()->json(['message' => 'Visit not found for this family member'], 404);
        }

        $validated = $request->validate([
            'date' => 'sometimes|date',
            'visit_type' => 'sometimes|string|in:متابعة الحمل,تنظيم الأسرة,متابعة طفل,أمراض مزمنة,زيارة دورية,أسنان',
            'complaint' => 'sometimes|string',
            'clinical_examination' => 'sometimes|string',
            'investigations' => 'nullable|string',
            'diagnoses' => 'sometimes|string',
            'management_follow_up' => 'sometimes|string',
        ]);

        $visit->update($validated);

        return response()->json(['message' => 'Visit updated successfully', 'data' => $visit]);
    }

    public function destroy(FamilyMember $familyMember, Visit $visit)
    {
        if ($visit->family_member_id !== $familyMember->id) {
            return response()->json(['message' => 'Visit does not belong to this family member.'], 403);
        }

        $visit->delete();

        return response()->json(['message' => 'Visit deleted successfully.']);
    }
}
