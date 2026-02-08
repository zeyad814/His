<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StoreGrowthMeasurementRequest;
use App\Models\ChildGrowthMeasurement;
use App\Models\Visit;
use App\Traits\ApiResponse;
use App\Traits\HasDoctorContext;
use Illuminate\Http\Request;

class ChildGrowthController extends Controller
{
    use HasDoctorContext;
    use ApiResponse;

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGrowthMeasurementRequest $request)
    {
        $this->getAuthenticatedDoctor();
        $data = $request->validated();

        $visit = Visit::find($data['visit_id']);
        if (!$visit || $visit->visit_type !== 'متابعة طفل')
        {
            return ApiResponse::errorResponse('Invalid visit type for growth measurements.', 422);
        }

        try
        {
            // 2. استخدام updateOrCreate عشان لو الدكتور حب يعدل القياسات في نفس الزيارة
            $measurement = ChildGrowthMeasurement::updateOrCreate(
                [
                    'family_member_id' => $data['family_member_id'],
                    'visit_id' => $data['visit_id'],
                ],
                [
                    'age_months' => $data['age_months'],
                    'head_circumference' => $data['head_circumference'],
                    'weight' => $data['weight'],
                    'height' => $data['height'],
                ]
            );

            return ApiResponse::successResponse(
                "Growth measurements saved successfully",
                201,
                $measurement
            );

        }
        catch (\Exception $e)
        {
            return ApiResponse::errorResponse("An error occurred while processing child growth measurements. Please try again.", 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($visit_id)
    {
        $this->getAuthenticatedDoctor();
        $measurement = ChildGrowthMeasurement::where('visit_id', $visit_id)->first();
        if (!$measurement)
        {
            return ApiResponse::errorResponse(
                "No growth records found for this visit. Please complete the assessment first.", 
                404
            );
        }

        return ApiResponse::successResponse(
            "Growth measurements retrieved successfully",
            200,
            $measurement
        );
    }

    /**
     * جلب جميع قياسات الطفل السابقة لرسم منحنى النمو
     */
    public function history($family_member_id)
    {
        $this->getAuthenticatedDoctor();
        $measurements = ChildGrowthMeasurement::where('family_member_id', $family_member_id)->get();
        if (!$measurements)
        {
            return ApiResponse::errorResponse(
                "No growth records found for this family member. Please complete the assessment first.", 
                404
            );
        }

        $formattedMeasurements = $measurements->map(function ($item) {
            return [
                "visit_id"           => $item->visit_id,
                "age_months"         => $item->age_months,
                "head_circumference" => $item->head_circumference,
                "weight"             => $item->weight,
                "height"             => $item->height,
            ];
        });

        return ApiResponse::successResponse(
            "Growth measurements retrieved successfully",
            200,
            $formattedMeasurements
        );
    }
}
