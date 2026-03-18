<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\StoreHealthAdministrationRequest;
use App\Http\Requests\SuperAdmin\UpdateHealthAdministrationRequest;
use App\Http\Resources\HealthAdministrationResource;
use App\Models\HealthAdministration;
use App\Traits\ApiResponse;
use App\Traits\HasSuperAdminContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HealthAdministrationController extends Controller
{
    use ApiResponse, HasSuperAdminContext;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->getAuthenticatedSuperAdmin();
        $administrations = HealthAdministration::withCount('healthUnits')
            ->latest()
            ->paginate(5);
        
        if ($administrations->isEmpty())
        {
            return ApiResponse::successResponse(
                "No health administrations found at the moment.", 
                200,
                []
            );
        }
        
        return ApiResponse::successResponse(
            "Health administrations retrieved successfully.",
            200,
            HealthAdministrationResource::collection($administrations)->response()->getData(true)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHealthAdministrationRequest $request)
    {
        $this->getAuthenticatedSuperAdmin();
        $data = $request->validated();
        DB::beginTransaction();
        try
        {
            $administration = HealthAdministration::create($data);

            DB::commit();
            return ApiResponse::successResponse(
                "Health administration created successfully.",
                200,
                new HealthAdministrationResource($administration)
            );
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return ApiResponse::errorResponse(
                'Something went wrong while creating the health administration, please try again.', 
                500
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $this->getAuthenticatedSuperAdmin();
        $administration = HealthAdministration::withCount('healthUnits')->find($id);
        if(!$administration)
        {
            return ApiResponse::errorResponse(
                "The requested Health Administration (ID: $id) was not found.", 
                404
            );
        }

        return ApiResponse::successResponse(
            "Health Administration details retrieved successfully.",
            200,
            new HealthAdministrationResource($administration)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHealthAdministrationRequest $request, $id)
    {
        $this->getAuthenticatedSuperAdmin();
        $data = $request->validated();
        $administration = HealthAdministration::find($id);
        if(!$administration)
        {
            return ApiResponse::errorResponse(
                "The requested Health Administration (ID: $id) was not found.", 
                404
            );
        }

        DB::beginTransaction();
        try
        {
            $administration->update($data);

            DB::commit();
            return ApiResponse::successResponse(
                "Health administration updated successfully.",
                200,
                new HealthAdministrationResource($administration)
            );

        }
        catch (\Exception $e)
        {
            DB::rollback();
            
            return ApiResponse::errorResponse(
                'Failed to update health administration. Please try again.', 
                500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->getAuthenticatedSuperAdmin();
        $administration = HealthAdministration::find($id);
        if (!$administration)
        {
            return ApiResponse::errorResponse(
                "Health Administration not found.", 
                404
            );
        }

        if ($administration->healthUnits()->exists())
        {
            return ApiResponse::errorResponse(
                "Cannot delete this administration because it has linked health units. Delete or reassign the units first.", 
                400
            );
        }

        DB::beginTransaction();
        try
        {
            $administration->delete();
            DB::commit();

            return ApiResponse::successResponse(
                "Health administration deleted successfully.",
                200
            );
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return ApiResponse::errorResponse(
                "Something went wrong while deleting, please try again.",
                500
            );
        }
    }
}
