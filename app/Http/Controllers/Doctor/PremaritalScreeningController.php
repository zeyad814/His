<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StorePremaritalScreeningRequest;
use App\Http\Requests\Doctor\UpdatePremaritalScreeningRequest;
use App\Http\Resources\PremaritalScreeningResource;
use App\Models\FamilyMember;
use App\Models\PremaritalScreening;
use App\Traits\ApiResponse;
use App\Traits\HasDoctorContext;


class PremaritalScreeningController extends Controller
{
    use HasDoctorContext;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $screenings = PremaritalScreening::with(['familyMember.family', 'doctor'])
            ->latest()->paginate(10);

        return ApiResponse::successResponse(
            'Premarital screenings retrieved successfully',
            200,
            PremaritalScreeningResource::collection($screenings)->response()->getData(true)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePremaritalScreeningRequest $request)
    {
        $validated = $request->validated();

        $member = FamilyMember::findOrFail($request->family_member_id);
        $validated['type'] = ($member->is_male == 1) ? 'groom' : 'bride';

        $validated['doctor_id'] = $this->getAuthenticatedDoctor()->id;

        if ($request->filled(['weight', 'height'])) {
            $heightInMeters = $request->height / 100;
            $validated['bmi'] = $request->weight / ($heightInMeters * $heightInMeters);
        }

        $screening = PremaritalScreening::create($validated);
        return ApiResponse::successResponse(
            'Premarital screening record created successfully',
            201,
            new PremaritalScreeningResource($screening)
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(PremaritalScreening $premarital_screening)
    {
        $premarital_screening->load(['familyMember', 'doctor']);

        return ApiResponse::successResponse(
            'Premarital screening details retrieved successfully',
            200,
            new PremaritalScreeningResource($premarital_screening)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePremaritalScreeningRequest $request, PremaritalScreening $premarital_screening)
    {
        $validated = $request->validated();

        if ($request->filled(['weight', 'height'])) {
            $heightInMeters = $request->height / 100;
            $validated['bmi'] = $request->weight / ($heightInMeters * $heightInMeters);
        } elseif ($request->filled('weight')) {
            $heightInMeters = $premarital_screening->height / 100;
            $validated['bmi'] = $request->weight / ($heightInMeters * $heightInMeters);
        } elseif ($request->filled('height')) {
            $heightInMeters = $request->height / 100;
            $validated['bmi'] = $premarital_screening->weight / ($heightInMeters * $heightInMeters);
        }


        $premarital_screening->update($validated);

        return ApiResponse::successResponse(
            'Premarital screening updated and BMI recalculated successfully',
            200,
            new PremaritalScreeningResource($premarital_screening->load(['familyMember', 'doctor']))
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PremaritalScreening $premarital_screening)
    {
        $premarital_screening->delete();

        return ApiResponse::successResponse(
            'Premarital screening record deleted successfully',
            200
        );
    }
}
