<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreNurseRequest;
use App\Http\Requests\Admin\UpdateNurseRequest;
use App\Models\Nurse;
use App\Traits\ApiResponse;
use App\Traits\HasAdminContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class NurseController extends Controller
{
    use ApiResponse, HasAdminContext;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->getAuthenticatedAdmin();
        $nurses = Nurse::with('user')->paginate(5);
        if(!$nurses)
        {
            return ApiResponse::errorResponse(
                'Nurses records not found.',
                404
            );
        }
        return ApiResponse::successResponse(
            'Nurses records fetched successfully.',
            200,
            $nurses
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNurseRequest $request)
    {
        $this->getAuthenticatedAdmin();
        $data = $request->validated();
        DB::beginTransaction();
        try
        {
            $nurse = Nurse::create([
                // 'health_unit_id' => $data->health_unit_id,
                'national_id' => $data["national_id"],
                'phone' => $data["phone"],
                'start_date' => $data["start_date"],
            ]);

            // 2. Create the User record (Polymorphic)
            $nurse->user()->create([
                'name' => $data["name"],
                'email' => $data["email"],
                'password' => Hash::make($data["password"]),
                'role' => 'data',
            ]);

            DB::commit();
             return ApiResponse::successResponse(
                'Nurse profile and access account created successfully.',
                201,
                ['nurse_id' => $nurse->id]
            );
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return ApiResponse::errorResponse(
                'Registration failed: Unable to create nurse profile at this time.',
                500
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $this->getAuthenticatedAdmin();
        $nurse = Nurse::with("user")->find($id);
        if(!$nurse)
        {
            return ApiResponse::errorResponse(
                'Nurse record not found.',
                404
            );
        }

        return ApiResponse::successResponse(
            'Nurse details fetched successfully.',
            200,
            $nurse
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNurseRequest $request, $id)
    {
        $this->getAuthenticatedAdmin();
        $data = $request->validated();
        $nurse = Nurse::with("user")->find($id);
        if(!$nurse)
        {
            return ApiResponse::errorResponse(
                'Nurse record not found.',
                404
            );
        }

        DB::beginTransaction();
        try
        {
            $nurse->update([
                // 'health_unit_id' => $data["health_unit_id"],
                'national_id' => $data["national_id"],
                'phone' => $data["phone"],
                'start_date' => $data["start_date"],
            ]);

            // 2. Update the User record (Polymorphic)
            $nurse->user()->update([
                'name' => $data["name"],
                'email' => $data["email"],
            ]);

            DB::commit();
             return ApiResponse::successResponse(
                'Nurse profile and access account updated successfully.',
                201,
                ['nurse_id' => $nurse->id]
            );
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return ApiResponse::errorResponse(
                'Registration failed: Unable to create nurse profile at this time.' . $e->getMessage(),
                500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->getAuthenticatedAdmin();
    }
}
