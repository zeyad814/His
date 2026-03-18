<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SuperAdmin\StoreAdminRequest;
use App\Http\Requests\SuperAdmin\UpdateAdminRequest;
use App\Http\Resources\AdminResource;
use App\Models\Admin;
use App\Traits\ApiResponse;
use App\Traits\HasSuperAdminContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    use ApiResponse, HasSuperAdminContext;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->getAuthenticatedSuperAdmin();
        $admins = Admin::with(['user', 'healthUnit'])->paginate(10);

        return ApiResponse::successResponse(
            "Admins list retrieved successfully.",
            200,
            AdminResource::collection($admins)->response()->getData(true)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminRequest $request)
    {
        $this->getAuthenticatedSuperAdmin();
        $data = $request->validated();
        DB::beginTransaction();
        try
        {
            $admin = Admin::create([
                'national_id' => $data['national_id'],
                'phone' => $data['phone'],
                'health_unit_id' => $data['health_unit_id'],
            ]);

            $admin->user()->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);

            DB::commit();
            $admin->load('user');

            return ApiResponse::successResponse(
                "Admin created successfully with access account.",
                201,
                new AdminResource($admin)
            );
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return ApiResponse::errorResponse(
                "Failed to create admin, please try again",
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
        $admin = Admin::with('user')->find($id);
        if(!$admin)
        {
            return ApiResponse::errorResponse(
                "The requested admin with ID: $id could not be found.", 
                404
            );
        }

        // $admin->load('user');
        return ApiResponse::successResponse(
            "Admin account details retrieved successfully.",
            200,
            new AdminResource($admin)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $request, string $id)
    {
        $this->getAuthenticatedSuperAdmin();
        $data = $request->validated();
        $admin = Admin::with('user')->find($id);
        if (!$admin)
        {
            return ApiResponse::errorResponse("Admin account not found.", 404);
        }

        DB::beginTransaction();
        try
        {
            $admin->update([
                'national_id' => $data['national_id'],
                'phone' => $data['phone'],
            ]);

            $admin->user()->update([
                'name' => $data['name'],
                'email' => $data['email'],
            ]);

            DB::commit();
            return ApiResponse::successResponse(
                "Admin and access account updated successfully.",
                200,
                new AdminResource($admin->fresh('user'))
            );

        }
        catch (\Exception $e)
        {
            DB::rollback();
            return ApiResponse::errorResponse(
                "Failed to update admin account details. Any pending changes have been reverted.",
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
        $admin = Admin::with('user')->find($id);
        if (!$admin)
        {
            return ApiResponse::errorResponse(
                "The admin account you are trying to delete does not exist.",
                404
            );
        }

        DB::beginTransaction();
        try
        {
            if ($admin->user)
            {
                $admin->user()->delete();
            }

            $admin->delete();

            DB::commit();
            return ApiResponse::successResponse(
                "Admin and its associated access account have been permanently deleted.",
                200
            );

        }
        catch (\Exception $e)
        {
            DB::rollback();    
            return ApiResponse::errorResponse(
                "An error occurred while deleting the admin account. Please try again.", 
                500
            );
        }
    }
}
