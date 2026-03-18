<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\StoreHealthUnitRequest;
use App\Http\Requests\SuperAdmin\UpdateHealthUnitRequest;
use App\Http\Resources\HealthUnitResource;
use App\Models\HealthUnit;
use App\Traits\ApiResponse;
use App\Traits\HasSuperAdminContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HealthUnitController extends Controller
{
    use ApiResponse, HasSuperAdminContext;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->getAuthenticatedSuperAdmin();
        // $units = HealthUnit::withCount(['doctors', 'nurses'])
        $units = HealthUnit::withCount(['doctors' , 'nurses'])
            ->latest()
            ->paginate(5);

        if ($units->isEmpty())
        {
            return ApiResponse::successResponse(
                "No health units found at the moment.",
                200,
                []
            );
        }

        return ApiResponse::successResponse(
            "Health units retrieved successfully with staff counts.",
            200,
            HealthUnitResource::collection($units)->response()->getData(true)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreHealthUnitRequest $request)
    {
        $this->getAuthenticatedSuperAdmin();
        $data = $request->validated();
        DB::beginTransaction();
        try
        {
            $unit = HealthUnit::create($data);

            DB::commit();
            return ApiResponse::successResponse(
                "Health unit created successfully",
                200,
                new HealthUnitResource($unit)
            );
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return ApiResponse::errorResponse(
                'Something went wrong while creating the health unit, please try again.', 
                404
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $this->getAuthenticatedSuperAdmin();
        $unit = HealthUnit::withCount(['doctors' , 'nurses'])->find($id);
        if(!$unit)
        {
            return ApiResponse::errorResponse(
                "The health unit does not exist or may have been deleted.", 
                404
            );
        }

        return ApiResponse::successResponse(
            "Health unit details retrieved successfully.",
            200,
            new HealthUnitResource($unit)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHealthUnitRequest $request, $id)
    {
        $this->getAuthenticatedSuperAdmin();
        $data = $request->validated();
        $unit = HealthUnit::find($id);
        if(!$unit)
        {
            return ApiResponse::errorResponse(
                "The health unit does not exist or may have been deleted.", 
                404
            );
        }

        DB::beginTransaction();
        try
        {
            $unit->update($data);
            
            DB::commit();
            return ApiResponse::successResponse(
                "Health unit updated successfully.",
                200,
                new HealthUnitResource($unit)
            );

        }
        catch (\Exception $e)
        {
            DB::rollback();
            
            return ApiResponse::errorResponse(
                "An error occurred while updating the health unit. Please try again.", 
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
        $unit = HealthUnit::find($id);
        if(!$unit)
        {
            return ApiResponse::errorResponse(
                "The health unit does not exist or may have been deleted.", 
                404
            );
        }

        if (
                $unit->doctors()->exists() 
                // || 
                // $unit->nurses()->exists() || 
                // $unit->medicalProcedures()->exists()
            )
        {
            return ApiResponse::errorResponse(
                "Cannot delete this health unit because it has linked records (Doctors, Nurses, or Medical Procedures). Please reassign or delete them first.", 
                400
            );
        }

        DB::beginTransaction();
        try
        {
            $unit->delete();
            DB::commit();

            return ApiResponse::successResponse(
                "Health unit deleted successfully.",
                200
            );
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return ApiResponse::errorResponse(
                "An error occurred while deleting the health unit. Please try again.",
                500
            );
        }
    }
}
