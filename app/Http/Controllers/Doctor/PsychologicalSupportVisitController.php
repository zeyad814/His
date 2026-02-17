<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StorePsychologicalSupportVisitRequest;
use App\Http\Resources\PsychologicalSupportVisitResource;
use App\Models\PsychologicalSupportVisit;
use App\Traits\ApiResponse;
use App\Traits\HasDoctorContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PsychologicalSupportVisitController extends Controller
{
    use HasDoctorContext;
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index($family_member_id)
    {
        $this->getAuthenticatedDoctor();
        $visits = PsychologicalSupportVisit::where('family_member_id', $family_member_id)
            ->latest()
            ->paginate(5);
        
        if ($visits->isEmpty())
        {
            return $this->successResponse(
                'No visits found for this family member',
                200
            );
        }
        
        return PsychologicalSupportVisitResource::collection($visits)
            ->additional([
                'success' => true,
                'message' => 'Visits data retrieved successfully'
            ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePsychologicalSupportVisitRequest $request)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $data = $request->validated();
        $data['doctor_id'] = $doctor->id;

        DB::beginTransaction();
        try {
            $psychologicalSupportVisit = PsychologicalSupportVisit::create($data);
            DB::commit();
            return $this->successResponse(
                'Psychological support visit created successfully',
                201,
                new PsychologicalSupportVisitResource($psychologicalSupportVisit)
            );
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return $this->errorResponse(
                'Failed to create psychological support visit',
                500,
                $e->getMessage()
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $this->getAuthenticatedDoctor();
        $visit = PsychologicalSupportVisit::find($id);
        if (!$visit)
        {
            return $this->errorResponse(
                'Visit not found',
                404
            );
        }

        return $this->successResponse(
            'Visit data retrieved successfully',
            200,
            new PsychologicalSupportVisitResource($visit)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePsychologicalSupportVisitRequest $request, $id)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $data = $request->validated();
        $data['doctor_id'] = $doctor->id;

        try
        {
            $visit = PsychologicalSupportVisit::find($id);
            if (!$visit)
            {
                return $this->errorResponse(
                    'Visit not found',
                    404
                );
            }
            $visit->update($data);

            return $this->successResponse(
                'Psychological support visit updated successfully',
                200,
                new PsychologicalSupportVisitResource($visit)
            );

        }
        catch (\Exception $e)
        {
            return $this->errorResponse(
                'Failed to update the visit. Please try again.',
                500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->getAuthenticatedDoctor();
        $visit = PsychologicalSupportVisit::find($id);
        if (!$visit)
        {
            return $this->errorResponse(
                'Visit not found',
                404
            );
        }
        $visit->delete();
        return $this->successResponse(
            'Psychological support visit deleted successfully',
            200
        );
    }
}
