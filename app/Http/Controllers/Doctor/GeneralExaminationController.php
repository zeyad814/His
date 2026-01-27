<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StoreFinalAssessmentRequest;
use App\Http\Requests\Doctor\StoreHistoryRequest;
use App\Http\Requests\Doctor\StoreSystemicExamRequest;
use App\Http\Requests\Doctor\StoreVitalsRequest;
use App\Models\GeneralExamination;
use App\Models\PhysicalExamination;
use App\Traits\HasDoctorContext;
use Illuminate\Http\Request;

class GeneralExaminationController extends Controller
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
    public function store(StoreHistoryRequest $request)
    {
        $data = $request->validated();
        $user = $this->getAuthenticatedDoctor();
        $history = PhysicalExamination::updateOrCreate(
        ['family_member_id' => $request->family_member_id],
            $data
        );

        return response()->json([
            'status' => 'success',
            'message' => 'General examination has been saved successfully.',
            'data' => [
                'family_member_id' => $history->family_member_id,
                'physical_examination_id' => $history->id,
            ]
        ], 200);
    }

    public function storeVitals(StoreVitalsRequest $request)
    {
        $data = $request->validated();
        $user = $this->getAuthenticatedDoctor();

        $vitals = GeneralExamination::updateOrCreate(
            ['physical_examination_id' => $data["physical_examination_id"]],
            $data
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Vitals and Lab results saved successfully.',
            'data' => [
                'physical_examination_id' => $vitals->physical_examination_id,
                'general_examination_id' => $vitals->id,
            ]
        ], 200);
    }

    public function storeSystemicExamination(StoreSystemicExamRequest $request)
    {
        $data = $request->validated();
        $user = $this->getAuthenticatedDoctor();

        $exam = GeneralExamination::updateOrCreate(
            ['physical_examination_id' => $data['physical_examination_id']],
            $data
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Systemic examination findings saved successfully.',
            'data' => [
                'physical_examination_id' => $exam->physical_examination_id,
                'general_examination_id' => $exam->id,
            ]
        ], 200);
    }

    public function storeFinalAssessment(StoreFinalAssessmentRequest $request)
    {
        $data = $request->validated();
        $user = $this->getAuthenticatedDoctor();
        $exam = GeneralExamination::updateOrCreate(
            ['physical_examination_id' => $request->physical_examination_id],
            $request->validated()
        );

        return response()->json([
            'status' => 'success',
            'message' => 'General examination assessment has been successfully processed.',
            // 'data' => $exam
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($family_member_id)
    {
        $user = $this->getAuthenticatedDoctor();
        $history = PhysicalExamination::select([
            'id',
            'family_member_id',
            'family_history',
            'hospitalization',
            'lab_tests_results',
            'special_habits',
            'previous_operations',
            'current_medication',
            'trauma_injuries',
            'allergy',
            'adverse_drug_reaction',
            'abuse_negligence',
            'psychiatric_history'
        ])
            ->where('family_member_id', $family_member_id)
            ->first();

        if (!$history)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No medical history found for this family member.',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Medical history retrieved successfully.',
            'data' => $history
        ], 200);
    }

    public function editVitals($physical_examination_id)
    {
        $user = $this->getAuthenticatedDoctor();
        $vitals = GeneralExamination::where('physical_examination_id', $physical_examination_id)->first();

        if (!$vitals)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No vital signs found for this examination.',
                'data' => null
            ], 404);
        }

        $filteredData = $vitals->only([
            'id',
            'physical_examination_id',
            'blood_pressure',
            'pulse',
            'temperature',
            'respiratory_rate',
            'height',
            'weight',
            'bmi',
            'general_appearance',
            'pain_assessment',
            "lab_results",
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Vitals retrieved successfully.',
            'data' => $filteredData
        ], 200);
    }

    public function editSystemic($physical_examination_id)
    {
        $user = $this->getAuthenticatedDoctor();
        $exam = GeneralExamination::where('physical_examination_id', $physical_examination_id)->first();

        if (!$exam)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No systemic examination findings found.',
                'data' => null
            ], 404);
        }

        $filteredData = $exam->only([
            'id',
            'physical_examination_id',
            'skin_complexion',
            'head_neck',
            'heart',
            'chest',
            'abdomen',
            'neurological',
            'upper_limb',
            'lower_limb',
            'disabilities',
            'risk_factors',
            'deformities',
            'eyes',
            'ent'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Systemic examination findings retrieved successfully.',
            'data' => $filteredData
        ], 200);
    }

    public function editFinalAssessment($physical_examination_id)
    {
        $user = $this->getAuthenticatedDoctor();
        $exam = GeneralExamination::where('physical_examination_id', $physical_examination_id)->first();

        if (!$exam)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'No final assessment found for this examination.',
                'data' => null
            ], 404);
        }

        $filteredData = $exam->only([
            'id',
            'physical_examination_id',
            'eyes',
            'ent',
            'risk_factors',
            'nutritional_assessment',
            'general_appearance',
            'conclusion'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Final assessment retrieved successfully.',
            'data' => $filteredData
        ], 200);
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
