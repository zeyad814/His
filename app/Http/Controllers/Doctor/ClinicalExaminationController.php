<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StoreClinicalExaminationRequest;
use App\Http\Requests\Doctor\UpdateClinicalExaminationRequest;
use App\Models\ClinicalExamination;
use App\Models\Visit;
use App\Traits\ApiResponse;
use App\Traits\HasDoctorContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClinicalExaminationController extends Controller
{
    use HasDoctorContext;
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index($family_member_id)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $examinations = ClinicalExamination::where('family_member_id', $family_member_id)
            ->get();

        $examinations->makeHidden([
            'family_member_id',
            'visit_id',
            'doctor_id',
            'created_at',
            'updated_at'
        ]);

        return ApiResponse::successResponse(
            'Clinical examinations retrieved successfully',
            200,
            $examinations
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClinicalExaminationRequest $request)
    {
        $data = $request->validated();
        $doctor = $this->getAuthenticatedDoctor();
        $message = null;
        $visit = Visit::find($data["visit_id"]);
        if (!$visit)
        {
            $message = 'Visit record not found.';
        }
        else if ($visit->visit_type !== 'متابعة طفل')
        {
            $message = 'Invalid visit type. Clinical examination can only be recorded for visits categorized as "متابعة طفل".';
        }
        else if ($visit->family_member_id != $data['family_member_id'])
        {
            $message = "Data Mismatch: The provided visit ID does not belong to the selected family member.";
        }

        if ($message)
        {
            return ApiResponse::errorResponse($message, 422);
        }

        $data["doctor_id"] = $doctor->id;

        DB::beginTransaction();
        try
        {
            $examination = ClinicalExamination::updateOrCreate(
                [
                    'family_member_id' => $data['family_member_id'],
                    'visit_id' => $data['visit_id']
                ],
                $data
            );

            DB::commit();
            return ApiResponse::successResponse(
                'The clinical assessment for this developmental stage has been saved.',
                200,
                ['id' => $examination->id]
            );

        }
        catch (\Exception $e)
        {
            DB::rollback();

            return ApiResponse::errorResponse(
                'Unable to save clinical assessment. Please check the provided data.',
                500
            );
        }
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
    public function edit($id)
    {
        $examination = ClinicalExamination::find($id);
        if (!$examination)
        {
            return ApiResponse::errorResponse('Clinical examination record not found.', 404);
        }

        $examination->makeHidden([
            'family_member_id',
            'visit_id',
            'doctor_id',
            'created_at',
            'updated_at'
        ]);

        return ApiResponse::successResponse(
            'Clinical examination data retrieved successfully',
            200,
            $examination
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClinicalExaminationRequest $request, string $id)
    {
        $data = $request->validated();
        $doctor = $this->getAuthenticatedDoctor();
        $examination = ClinicalExamination::find($id);
        if (!$examination)
        {
            return ApiResponse::errorResponse('Clinical examination record not found.', 404);
        }

        DB::beginTransaction();
        try
        {
            $examination->update($data);
            DB::commit();

            return ApiResponse::successResponse(
                'The clinical assessment has been updated successfully.',
                200,
                ['id' => $examination->id]
            );

        }
        catch (\Exception $e)
        {
            DB::rollback();

            return ApiResponse::errorResponse(
                'Unable to update clinical assessment. Please check the provided data.',
                500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $examination = ClinicalExamination::find($id);
        if (!$examination)
        {
            return ApiResponse::errorResponse('Clinical examination record not found.', 404);
        }

        try
        {
            $examination->delete();

            return ApiResponse::successResponse(
                'The clinical examination record has been successfully deleted.',
                200
            );
        }
        catch (\Exception $e)
        {
            return ApiResponse::errorResponse(
                'Unable to delete the record. It may be linked to other medical data.',
                500
            );
        }
    }
}
