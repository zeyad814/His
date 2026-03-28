<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StoreGeriatricAssessmentRequest;
use App\Http\Requests\Doctor\UpdateGeriatricAssessmentRequest;
use App\Http\Resources\GeriatricAssessmentResource;
use App\Models\GeriatricAssessment;
use App\Traits\ApiResponse;
use App\Traits\HasDoctorContext;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeriatricAssessmentController extends Controller
{
    use ApiResponse;
    use HasDoctorContext;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $records = GeriatricAssessment::with([
            'familyMember',
            'doctor.user',
            'answers.question'
        ])->get();

        return ApiResponse::successResponse(
            'Geriatric Assessment data returned Successfully',
            200,
            GeriatricAssessmentResource::collection($records)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGeriatricAssessmentRequest $request)
    {
        $doctor = $this->getAuthenticatedDoctor();

        try {
            return DB::transaction(function () use ($request, $doctor) {
                //تسجيل رأس التقييم
                $assessment = GeriatricAssessment::create([
                    'family_member_id' => $request->family_member_id,
                    'overall_status' => $request->overall_status,
                    'doctor_recommendations' => $request->doctor_recommendations,
                    'doctor_id' => $doctor->id,
                ]);

                //تسجيل مصفوفة الإجابات
                foreach ($request->answers as $answer) {
                    $assessment->answers()->create([
                        'assessment_question_id' => $answer['question_id'],
                        'answer_value' => $answer['answer_value'],
                    ]);
                }

                //تحميل العلاقات للرد النهائي
                return ApiResponse::successResponse(
                    'Geriatric Assessment saved successfully by ' . $doctor->user->name,
                    201,
                    new GeriatricAssessmentResource($assessment->load(['answers.question', 'familyMember', 'doctor.user']))
                );
            });
        } catch (\Exception $e) {
            return ApiResponse::errorResponse('Failed to save assessment: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(GeriatricAssessment $geriatric_assessment)
    {
        $geriatric_assessment->load(['familyMember', 'doctor.user', 'answers.question']);

        return ApiResponse::successResponse(
            'Geriatric Assessment details retrieved successfully',
            200,
            new GeriatricAssessmentResource($geriatric_assessment)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGeriatricAssessmentRequest $request, GeriatricAssessment $geriatric_assessment)
    {
        $doctor = $this->getAuthenticatedDoctor();
        try {
            return DB::transaction(function () use ($request, $geriatric_assessment, $doctor) {

                // تحديث البيانات الأساسية (بياخد بس اللي اتبعت في الريكويست)
                $geriatric_assessment->update([
                    'family_member_id'       => $request->family_member_id ?? $geriatric_assessment->family_member_id,
                    'overall_status'         => $request->overall_status ?? $geriatric_assessment->overall_status,
                    'doctor_recommendations' => $request->doctor_recommendations ?? $geriatric_assessment->doctor_recommendations,
                    'doctor_id'              => $doctor->id, // ضمان إن الدكتور الحالي هو اللي بيتسجل كـ Updater
                ]);

                // تحديث الإجابات
                foreach ($request->answers as $answer) {
                    $geriatric_assessment->answers()->updateOrCreate(
                        ['assessment_question_id' => $answer['question_id']],
                        ['answer_value'           => $answer['answer_value']]
                    );
                }

                return ApiResponse::successResponse(
                    'Assessment updated successfully',
                    200,
                    new GeriatricAssessmentResource($geriatric_assessment->load('answers.question'))
                );
            });
        } catch (\Exception $e) {
            return ApiResponse::errorResponse('Update failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GeriatricAssessment $geriatric_assessment)
    {
        try {
        $geriatric_assessment->delete();

        return ApiResponse::successResponse(
            'Geriatric Assessment and all related answers have been deleted successfully.',
            200
        );
        
    } catch (\Exception $e) {
       
        return ApiResponse::errorResponse(
            'Failed to delete assessment: ' . $e->getMessage(), 
            500
        );
    }
    }
}
