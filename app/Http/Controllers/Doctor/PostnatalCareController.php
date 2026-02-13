<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StorePostnatalCareRequest;
use App\Http\Requests\Doctor\UpdatePostnatalCareRequest;
use App\Http\Resources\PostnatalCareResource;
use App\Models\PostnatalCare;
use App\Traits\ApiResponse;
use App\Traits\HasDoctorContext;
use Illuminate\Http\Request;

class PostnatalCareController extends Controller
{
    use HasDoctorContext;
    public function index()
    {
        $records = PostnatalCare::with('pregnancy.familyMember', 'doctor')
        ->latest()->paginate(10);

        return ApiResponse::successResponse(
            'Postnatal records retrieved successfully',
            200,
            PostnatalCareResource::collection($records)->response()->getData(true)
        );
    }

    public function store(StorePostnatalCareRequest $request)
    {
        $validated = $request->validated();

        $doctor = $this->getAuthenticatedDoctor();
        $validated['doctor_id'] = $doctor->id;

        $postnatal = PostnatalCare::create($validated);
        $postnatal->load(['pregnancy.familyMember', 'doctor']);

        return ApiResponse::successResponse(
            'Postnatal care created successfilly',
            201,
            new PostnatalCareResource($postnatal)

        );  
    }

    public function show(PostnatalCare $postnatalCare)
    {
       $postnatalCare->load(['pregnancy.familyMember', 'doctor']);

       return ApiResponse::successResponse(
        'Postnatal care data retrieved successfully',
        200,
        new PostnatalCareResource($postnatalCare)
       );
    }

    public function update(UpdatePostnatalCareRequest $request, PostnatalCare $postnatalCare)
    {
       $validated = $request->validated();
       $postnatalCare->update($validated);

       $postnatalCare->load(['pregnancy.familyMember', 'doctor']);

       return ApiResponse::successResponse(
         'Postnatal care data updated successfully',
         200,
         new PostnatalCareResource($postnatalCare)
       );
    }

    public function destroy(PostnatalCare $postnatalCare)
    {
        $postnatalCare->delete();

        return ApiResponse::successResponse(
            'The record deleted successfully',
            200
        );
    }
}
