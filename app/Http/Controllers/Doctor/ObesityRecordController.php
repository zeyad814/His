<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StoreObesityRequest;
use App\Http\Resources\ObesityRecordResource;
use App\Models\ObesityRecord;
use App\Models\Visit;
use App\Traits\ApiResponse;
use App\Traits\HasDoctorContext;
use Illuminate\Http\Request;

class ObesityRecordController extends Controller
{
    use HasDoctorContext;
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index($family_member_id)
    {
        $this->getAuthenticatedDoctor();
        $records = ObesityRecord::where('family_member_id', $family_member_id)
            ->paginate(5);

        if ($records->isEmpty())
        {
            return ApiResponse::errorResponse("No obesity records found for this family member.", 404);
        }

        $data = ObesityRecordResource::collection($records)
            ->additional(['context' => 'index']);

        return ApiResponse::successResponse(
            "Obesity records retrieved successfully.",
            200,
            $data->response()->getData(true)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreObesityRequest $request)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $data = $request->validated();

        $visit = Visit::find($data['visit_id']);
        if (!$visit || $visit->visit_type !== 'أمراض مزمنة')
        {
            return ApiResponse::errorResponse('Invalid visit type for obesity record.', 422);
        }

        try
        {
            $obesityRecord = ObesityRecord::updateOrCreate(
                [
                    'family_member_id' => $data['family_member_id'],
                    'visit_id' => $data['visit_id'],
                ],
                [
                    'visit_id' => $data['visit_id'],
                    'visit_date' => $data['visit_date'],
                    'visit_type' => $data['visit_type'],
                    'weight' => $data['weight'],
                    'height' => $data['height'],
                    'nutrition_counseling' => $data['nutrition_counseling'],
                    'dietary_plan' => $data['dietary_plan'],
                    'referral' => $data['referral'],
                    'doctor_id' => $doctor->id,
                ]
            );

            $message = $obesityRecord->wasRecentlyCreated 
               ? "Obesity record created successfully" 
               : "Obesity record updated successfully";

            $status = $obesityRecord->wasRecentlyCreated ? 201 : 200;
            return ApiResponse::successResponse(
                $message,
                $status,
                $obesityRecord
            );
        }
        catch (\Exception $e)
        {
            return ApiResponse::errorResponse("An error occurred while processing obesity record. Please try again.", 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $this->getAuthenticatedDoctor();
        $record = ObesityRecord::find($id);
        if (!$record)
        {
            return ApiResponse::errorResponse("Obesity record not found.", 404);
        }

        $data = (new ObesityRecordResource($record))
            ->additional(['context' => 'edit']);

        return ApiResponse::successResponse(
            "Obesity records retrieved successfully.",
            200,
            $data
        );
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->getAuthenticatedDoctor();
        $record = ObesityRecord::find($id);
        if (!$record)
        {
            return ApiResponse::errorResponse("Obesity record not found.", 404);
        }

        $record->delete();

        return ApiResponse::successResponse(
            "Obesity record deleted successfully.",
            200,
        );
    }
}
