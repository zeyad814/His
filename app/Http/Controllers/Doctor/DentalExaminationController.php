<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StoreDentalExaminationRequest;
use App\Http\Requests\Doctor\UpdateDentalExaminationRequest;
use App\Http\Resources\DentalExaminationResource;
use App\Models\DentalExamination;
use App\Traits\ApiResponse;
use App\Traits\HasDoctorContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DentalExaminationController extends Controller
{
    use ApiResponse, HasDoctorContext;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $this->getAuthenticatedDoctor();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDentalExaminationRequest $request)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $data = $request->validated();
        $data["doctor_id"] = $doctor->id;
        DB::beginTransaction();
        try
        {
            $examination = DentalExamination::create(collect($data)->except('tooth_statuses')->toArray());
            $examination->toothStatuses()->createMany($data['tooth_statuses']);
            
            DB::commit();
            return ApiResponse::successResponse(
                'Dental examination and tooth status records have been created successfully.',
                200,
                new DentalExaminationResource($examination)
            );
        }
        catch (\Exception $e)
        {
            DB::rollBack();

            return ApiResponse::errorResponse(
                'An error occurred while saving the examination data. Please try again later.',
                500
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $this->getAuthenticatedDoctor();
        $examination = DentalExamination::with('toothStatuses')->find($id);

        // 3. التحقق إذا كان الفحص موجود فعلاً
        if (!$examination)
        {
            return ApiResponse::errorResponse(
                'The requested dental examination record was not found.',
                404
            );
        }

        return ApiResponse::successResponse(
            'Dental examination record retrieved successfully.',
            200,
            new DentalExaminationResource($examination)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDentalExaminationRequest $request, $id)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $data = $request->validated();
        $data["doctor_id"] = $doctor->id;

        DB::beginTransaction();
        try
        {
            $examination = DentalExamination::with('toothStatuses')->find($id);
            if (!$examination)
            {
                return ApiResponse::errorResponse(
                    'The dental examination record you are trying to update was not found.',
                    404
                );
            }

            $examination->update(collect($data)->except('tooth_statuses')->toArray());
            $examination->toothStatuses()->delete();
            $examination->toothStatuses()->createMany($data['tooth_statuses']);

            DB::commit();
            return ApiResponse::successResponse(
                'Dental examination record updated successfully.',
                200,
                new DentalExaminationResource($examination)
            );
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return ApiResponse::errorResponse(
                'An error occurred while updating the examination data. Please try again later.',
                500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->getAuthenticatedDoctor();
        DB::beginTransaction();
        try
        {
            $examination = DentalExamination::with('toothStatuses')->find($id);
            if (!$examination)
            {
                return ApiResponse::errorResponse(
                    'The dental examination record you are trying to delete was not found.',
                    404
                );
            }

            $examination->delete();
            DB::commit();
            return ApiResponse::successResponse(
                'The dental examination record and all associated tooth data have been successfully deleted.',
                200
            );

        }
        catch (\Exception $e)
        {
            DB::rollback();
            return ApiResponse::errorResponse(
                'An error occurred while attempting to delete the record. Please try again.',
                500
            );
        }
    }
}
