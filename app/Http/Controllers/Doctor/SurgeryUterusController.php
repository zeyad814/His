<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSurgeryUterusRequest;
use App\Http\Requests\UpdateSurgeryUterusRequest;
use App\Http\Resources\SurgeryUterusResource;
use App\Models\SurgeryUterus;
use App\Traits\ApiResponse;
use App\Traits\HasDoctorContext;
use Illuminate\Support\Facades\DB;

class SurgeryUterusController extends Controller
{
    use ApiResponse;
    use HasDoctorContext;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $surgeries = SurgeryUterus::with(
            ['doctor', 'nurse', 'familyPlanning.familyMember', 'equipments']
        )->get();

        return ApiResponse::successResponse(
            'Surgery Uterus data returned Successfully',
            200,
            SurgeryUterusResource::collection($surgeries)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSurgeryUterusRequest $request)
    {
        $validated = $request->validated();

        $doctor = $this->getAuthenticatedDoctor();
        $validated['doctor_id'] = $doctor->id;

        $surgery = DB::transaction(function () use ($validated) {

            // حفظ العملية الأساسية
            $surgeryRecord = SurgeryUterus::create($validated);

            // حفظ الأدوات المرفقة
            $surgeryRecord->equipments()->createMany($validated['equipments']);

            return $surgeryRecord; // بنرجع السجل عشان نستقبله بره
        });

        return ApiResponse::successResponse(
            'Surgery Uterus created successfully',
            201,
            new SurgeryUterusResource($surgery->load('equipments'))
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(SurgeryUterus $surgery_uteru)
    {
        $surgery_uteru->load(['doctor', 'nurse', 'familyPlanning.familyMember', 'equipments']);

        return ApiResponse::successResponse(
            'Surgery Uterus record retrieved successfully',
            200,
            new SurgeryUterusResource($surgery_uteru)
        );
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSurgeryUterusRequest $request, SurgeryUterus $surgery_uteru)
    {
        $validated = $request->validated();

        $surgery = DB::transaction(function () use ($validated, $surgery_uteru) {

            //  تحديث البيانات الأساسية
            $surgery_uteru->update($validated);

            //  تحديث الأدوات (لو مبعوتة في الريكويست)
            if (isset($validated['equipments'])) {
                // نمسح القديم وننزل الجديد (Mirroring strategy)
                $surgery_uteru->equipments()->delete();
                $surgery_uteru->equipments()->createMany($validated['equipments']);
            }

            return $surgery_uteru;
        });

        return ApiResponse::successResponse(
            'Surgery record updated successfully',
            200,
            new SurgeryUterusResource($surgery->load('equipments'))
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SurgeryUterus $surgery_uteru)
    {
        // if ($surgery_uteru->doctor_id !== $this->getAuthenticatedDoctor()->id) {
        //     return ApiResponse::errorResponse('You are not authorized to delete this record', 403);
        // }
        $surgery_uteru->delete();

        return ApiResponse::successResponse(
            'Surgery record moved to trash successfully',
            200
        );
    }
}
