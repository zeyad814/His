<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOutpatientNursingAssessmentRequest;
use App\Http\Requests\UpdateOutpatientNursingAssessmentRequest;
use App\Http\Resources\OutpatientNursingAssessmentResource;
use App\Models\OutpatientNursingAssessment;
use App\Traits\ApiResponse;
use App\Traits\HasNurseContext;
use Illuminate\Support\Facades\DB;

class OutpatientNursingAssessmentController extends Controller
{
    use ApiResponse;
    use HasNurseContext;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = OutpatientNursingAssessment::with([
            'familyMember',
            'nurse',
            'fallAssessment'
        ])->latest()->paginate(10);

        return ApiResponse::successResponse(
            'Outpatient Nursing Assessment records retrieved successfully',
            200,
            OutpatientNursingAssessmentResource::collection($records)->response()->getData(true)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOutpatientNursingAssessmentRequest $request)
    {
        $nurse = $this->getAuthenticatedNurse();

        return DB::transaction(function () use ($request) {
            $nurseId = 1;
            // 1. تخزين التقييم الرئيسي
            $assessment = OutpatientNursingAssessment::create(array_merge(
                $request->validated(),
                ['nurse_id' => $nurseId]
            ));

            // 2. لو فيه تقييم سقوط، نفلتر الداتا بتاعته ونخزنها
            if ($request->needs_detailed_fall_assessment) {

                // هنجمع الحقول اللي بتبدأ بـ m_ أو h_ بناءً على النوع
                $fallFields = ($request->scale_type === 'morse')
                    ? $request->only(['m_history_falling', 'm_secondary_diagnosis', 'm_ambulatory_aid', 'm_iv_therapy', 'm_gait_transferring', 'm_mental_status'])
                    : $request->only(['h_age', 'h_gender', 'h_diagnosis', 'h_cognitive_impairments', 'h_environmental_factors', 'h_surgery_sedation_anesthesia', 'h_medication_usage']);

                $totalScore = array_sum($fallFields);
                $riskLevel = $this->calculateRiskLevel($request->scale_type, $totalScore);

                $assessment->fallAssessment()->create(array_merge($fallFields, [
                    'scale_type'  => $request->scale_type,
                    'total_score' => $totalScore,
                    'risk_level'  => $riskLevel,
                ]));

                // تحديث الحالة في الجدول الرئيسي
                $assessment->update(['final_fall_risk_level' => $riskLevel]);
            }

            return ApiResponse::successResponse(
                'Nursing Assessment and Fall Risk saved successfully',
                201,
                new OutpatientNursingAssessmentResource($assessment->load('fallAssessment'))
            );
        });
    }



    /**
     * Display the specified resource.
     */
    public function show(OutpatientNursingAssessment $outpatient_nursing_assessment)
    {
        $outpatient_nursing_assessment->load(['fallAssessment', 'familyMember', 'nurse']);

        return ApiResponse::successResponse(
            'Assessment record retrieved successfully',
            200,
            new OutpatientNursingAssessmentResource($outpatient_nursing_assessment)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOutpatientNursingAssessmentRequest $request, OutpatientNursingAssessment $outpatient_nursing_assessment)
    {
        $nurse = $this->getAuthenticatedNurse();
        
        return DB::transaction(function () use ($request, $outpatient_nursing_assessment) {

            // 1. تحديث البيانات الأساسية
            $outpatient_nursing_assessment->update($request->validated());

            // 2. تحديث أو إنشاء تقييم السقوط
            if ($request->hasAny(['scale_type', 'm_history_falling', 'h_age'])) { // لو باعت أي داتا تخص السقوط

                // بنلم داتا السقوط (نفس اللوجيك بتاع الـ Store)
                $fallFields = $this->getFallFields($request);
                $totalScore = array_sum($fallFields);
                $riskLevel = $this->calculateRiskLevel($request->scale_type ?? $outpatient_nursing_assessment->fallAssessment->scale_type, $totalScore);

                // updateOrCreate عشان لو مكنش ليه تقييم سقوط قبل كدة يكريته
                $outpatient_nursing_assessment->fallAssessment()->updateOrCreate(
                    ['outpatient_nursing_assessment_id' => $outpatient_nursing_assessment->id],
                    array_merge($fallFields, [
                        'total_score' => $totalScore,
                        'risk_level'  => $riskLevel
                    ])
                );

                $outpatient_nursing_assessment->update(['final_fall_risk_level' => $riskLevel]);
            }

            return ApiResponse::successResponse(
                'Assessment updated successfully',
                200,
                new OutpatientNursingAssessmentResource($outpatient_nursing_assessment->load('fallAssessment'))
            );
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OutpatientNursingAssessment $outpatientNursingAssessment)
    {
        $outpatientNursingAssessment->delete();

        return ApiResponse::successResponse(
            'Assessment record and its related data deleted successfully',
            200
        );
    }

    /**
     * دالة مساعدة لتجميع حقول تقييم السقوط من الـ Request
     */
    private function getFallFields($request)
    {
        if ($request->scale_type === 'morse') {
            return $request->only([
                'm_history_falling',
                'm_secondary_diagnosis',
                'm_ambulatory_aid',
                'm_iv_therapy',
                'm_gait_transferring',
                'm_mental_status'
            ]);
        }

        return $request->only([
            'h_age',
            'h_gender',
            'h_diagnosis',
            'h_cognitive_impairments',
            'h_environmental_factors',
            'h_surgery_sedation_anesthesia',
            'h_medication_usage'
        ]);
    }

    /**
     * دالة حساب مستوى الخطر بناءً على النوع والسكور
     */
    private function calculateRiskLevel($type, $score)
    {
        if ($type === 'morse') {
            if ($score >= 45) return 'High Risk';
            if ($score >= 25) return 'Moderate Risk';
            return 'Low Risk';
        }

        // Humpty Dumpty
        return ($score >= 12) ? 'High Risk' : 'Low Risk';
    }
}
