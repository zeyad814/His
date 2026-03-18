<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreDoctorRequest;
use App\Http\Requests\Admin\UpdateDoctorRequest;
use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use App\Traits\ApiResponse;
use App\Traits\HasAdminContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    use ApiResponse, HasAdminContext;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin = $this->getAuthenticatedAdmin();
        $doctors = Doctor::with(['user', 'healthUnit'])->paginate(10);

        return ApiResponse::successResponse(
            'Doctors list retrieved successfully.',
            200,
            DoctorResource::collection($doctors)->response()->getData(true)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDoctorRequest $request)
    {
        $admin = $this->getAuthenticatedAdmin();
        $data = $request->validated();
        DB::beginTransaction();
        try
        {
            $doctor = Doctor::create([
                "national_id" => $data["national_id"],
                "phone" => $data["phone"],
                "specialization" => $data["specialization"],
                "license_number" => $data["license_number"],
                "start_date" => $data["start_date"],
                "health_unit_id" => $data["health_unit_id"],
            ]);

            $doctor->user()->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => 'doctor',
            ]);

            DB::commit();
            return ApiResponse::successResponse(
                'Doctor profile and access account created successfully.',
                200,
                new DoctorResource($doctor)
            );
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return ApiResponse::errorResponse(
                'Registration failed: A system error occurred while setting up the doctor profile.',
                500
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $admin = $this->getAuthenticatedAdmin();
        $doctor = Doctor::with("user")->find($id);
        if(!$doctor)
        {
            return ApiResponse::errorResponse(
                'The requested doctor profile could not be found or you do not have permission to view it.',
                404
            );
        }

        return ApiResponse::successResponse(
            'Doctor profile retrieved successfully.',
            200,
            new DoctorResource($doctor)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDoctorRequest $request, $id)
    {
        $admin = $this->getAuthenticatedAdmin();
        $data = $request->validated();
        $doctor = Doctor::with("user")->find($id);
        if(!$doctor)
        {
            return ApiResponse::errorResponse(
                'The requested doctor profile could not be found or you do not have permission to view it.',
                404
            );
        }

        DB::beginTransaction();
        try
        {
            $doctor->update([
                "national_id" => $data["national_id"],
                "phone" => $data["phone"],
                "specialization" => $data["specialization"],
                "license_number" => $data["license_number"],
                "start_date" => $data["start_date"],
            ]);

            $doctor->user()->update([
                'name' => $data['name'],
                'email' => $data['email'],
                // 'password' => Hash::make($data['password']),
                'role' => 'doctor',
            ]);
            
            DB::commit();
            return ApiResponse::successResponse(
                'Doctor profile and security credentials updated successfully.',
                200,
                new DoctorResource($doctor)
            );
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return ApiResponse::errorResponse(
                'Update failed: The system encountered an error while saving the changes.',
                500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy($id)
    // {
    //     $admin = $this->getAuthenticatedAdmin();
    //     $doctor = Doctor::with("user")->find($id);
    //     if(!$doctor)
    //     {
    //         return ApiResponse::errorResponse(
    //             'The requested doctor profile could not be found or you do not have permission to view it.',
    //             404
    //         );
    //     }

    //     if ($doctor->hasAnyRelatedRecords())
    //     {
    //         return ApiResponse::errorResponse(
    //             'Cannot delete doctor: This profile is linked to existing medical history or patient visits.', 
    //             400
    //         );
    //     }

    //     DB::beginTransaction();
    //     try
    //     {
    //         $doctor->user()->delete();            
    //         $doctor->delete();

    //         DB::commit();
    //         return ApiResponse::successResponse('Doctor profile and associated account deleted successfully.', 200);

    //     }
    //     catch (\Exception $e)
    //     {
    //         DB::rollBack();
    //         return ApiResponse::errorResponse('Failed to delete doctor due to a system error.', 500);
    //     }
    // }
}
