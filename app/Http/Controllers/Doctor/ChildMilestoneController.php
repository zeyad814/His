<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StoreChildMilestoneRequest;
use App\Models\ChildMilestoneResult;
use App\Traits\ApiResponse;
use App\Traits\HasDoctorContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\DevelopmentalMilestoneLookup;
use App\Models\Visit;

class ChildMilestoneController extends Controller
{
    use HasDoctorContext;
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * 1. جلب قائمة "الأعمار" المتاحة (عشان الطبيب يختار منها)
     */
    public function getMilestoneStages()
    {
        $doctor = $this->getAuthenticatedDoctor();
        $stages = DevelopmentalMilestoneLookup::select('age_range')
            ->distinct()
            ->orderBy('age_range')
            ->get();

        return ApiResponse::successResponse(
            'Clinical examinations retrieved successfully',
            200,
            $stages
        );
    }

    /**
     * 2. جلب الأسئلة التابعة للفئة العمرية المختارة
     */
    public function getQuestionsByStage(Request $request)
    {
        $this->getAuthenticatedDoctor();
        $data = $request->validate([
            'age_range' => 'required|string|exists:developmental_milestone_lookups,age_range',
        ]);

        $questions = DevelopmentalMilestoneLookup::where('age_range', $data['age_range'])
            ->get(['id', 'question_text_ar']);

        return ApiResponse::successResponse(
            "Developmental milestone questions retrieved successfully",
            200,
            $questions
        );
    }

    /**
     * 3. حفظ إجابات الطفل
     */
    public function store(StoreChildMilestoneRequest $request)
    {
        $data = $request->validated();
        $doctor = $this->getAuthenticatedDoctor();
        $visit = Visit::find($data['visit_id']);
        if ($visit->visit_type !== 'متابعة طفل')
        {
            return ApiResponse::errorResponse(
                'Invalid visit type. Milestone assessments are only allowed for "متابعة طفل" visits.',
                422
            );
        }

        DB::beginTransaction();
        try
        {
            foreach ($data['answers'] as $answer) {
                ChildMilestoneResult::updateOrCreate(
                    [
                        'family_member_id' => $data['family_member_id'],
                        'milestone_lookup_id' => $answer['milestone_lookup_id'],
                    ],
                    [
                        'visit_id' => $data['visit_id'],
                        'is_achieved' => $answer['is_achieved'],
                    ]
                );
            }

            DB::commit();
            return ApiResponse::successResponse(
                "Developmental milestone answers saved successfully",
                200,
                null
            );
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return ApiResponse::errorResponse(
                'Unable to save developmental milestone answers. Please check the provided data.',
                500
            );
        }
    }

    /**
     * 4. عرض نتائج التقييم
     */
    public function show($family_member_id)
    {
        $this->getAuthenticatedDoctor();

        $results = ChildMilestoneResult::with('milestone')
            ->where('family_member_id', $family_member_id)
            ->get();

        if ($results->isEmpty())
        {
            return ApiResponse::successResponse(
                'No milestone records found for this child.',
                200,
                []
            );
        }

        $groupedResults = $results->groupBy(function ($item)
        {
            return $item->milestone->age_range;
        })->map(function ($items)
        {
            return $items->map(function ($result)
            {
                return [
                    'question_text_ar' => $result->milestone->question_text_ar,
                    'is_achieved' => $result->is_achieved,
                ];
            });
        });

        return ApiResponse::successResponse(
            "Child milestone history retrieved and categorized successfully",
            200,
            $groupedResults
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $family_member_id)
    {
        $this->getAuthenticatedDoctor();
        $data = $request->validate([
            'age_range' => 'required|string|exists:developmental_milestone_lookups,age_range',
        ]);

        $results = ChildMilestoneResult::with('milestone')
        ->where('family_member_id', $family_member_id)
        ->whereHas('milestone', function ($query) use ($data) {
            $query->where('age_range', $data['age_range']);
        })
        ->get();

        if ($results->isEmpty())
        {
            return ApiResponse::errorResponse(
                'No assessment found for this age range. Please complete the initial assessment first.',
                404
            );
        }

        $formattedData = $results->map(function ($result)
        {
            return [
                'milestone_lookup_id' => $result->milestone_lookup_id,
                'question_text_ar' => $result->milestone->question_text_ar,
                'is_achieved' => $result->is_achieved,
            ];
        });

        return ApiResponse::successResponse(
            "Data for [{$data['age_range']}] retrieved successfully",
            200,
            $formattedData
        );
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
