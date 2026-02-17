<?php

namespace App\Http\Controllers\Doctor;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Models\ChronicDisease;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class ChronicDiseaseController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $diseases = ChronicDisease::with(['familyMember'])->get();
        if ($diseases->isEmpty()) {
            return ApiResponse::errorResponse(
                "No chronic diseases found",
                404
            );
        }

        return ApiResponse::successResponse(
            "The diseases returned successfully",
            200,
            $diseases
        );
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'family_member_id' => 'required|exists:family_members,id',
            'diagnosis' => [
                'required',
                'string',
                'max:255',
                Rule::unique('chronic_diseases')
                    ->where('family_member_id', $request->family_member_id)
            ],
            'date_diagnosed' => 'nullable|date',
            'risk_factors' => 'nullable|string',
        ]);

        $disease = ChronicDisease::create($validated);
        return ApiResponse::successResponse(
            "Chronic disease created successfully",
            201,
            $disease
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $disease = ChronicDisease::with('familyMember')->find($id);

        if (!$disease) {
            return ApiResponse::errorResponse(
                'Chronic disease not found',
                404
            );
        }
        return ApiResponse::successResponse(
            'Chronic disease returned successfully',
            200,
            $disease
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $disease = ChronicDisease::find($id);

        if (!$disease) {
            return ApiResponse::errorResponse(
                'Chronic disease not found',
                404
            );
        }

        $validated = $request->validate([
            'diagnosis' => [
                'required',
                'string',
                'max:255',
                Rule::unique('chronic_diseases')->where('family_member_id', $disease->family_member_id)
                    ->ignore($disease->id),
            ],
            'date_diagnosed' => 'nullable|date',
            'risk_factors' => 'nullable|string',
        ]);

        $disease->update($validated);

        return ApiResponse::successResponse(
            'Chronic disease update successfully',
            200,
            $disease
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChronicDisease $chronicDisease)
    {
        $chronicDisease->delete();

        return ApiResponse::successResponse(
            "Chronic disease deleted successfully",
            200
        );
    }
}
