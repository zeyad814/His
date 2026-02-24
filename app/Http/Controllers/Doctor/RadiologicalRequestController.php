<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StoreRadiologicalRequest;
use App\Http\Requests\Doctor\UpdateRadiologicalRequest;
use App\Http\Resources\RadiologicalRequestResource;
use App\Models\RadiologicalRequest;
use App\Traits\ApiResponse;
use App\Traits\HasDoctorContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RadiologicalRequestController extends Controller
{
    use HasDoctorContext;
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index($family_member_id)
    {
        $this->getAuthenticatedDoctor();
        $orders = RadiologicalRequest::with(['familyMember', 'doctor'])
            ->where('family_member_id', $family_member_id)
            ->latest()
            ->paginate(5);

        if ($orders->isEmpty())
        {
            return ApiResponse::successResponse("No orders found for this family member", 200, []);
        }

        return ApiResponse::successResponse(
            'Radiological requests retrieved successfully',
            200,
            RadiologicalRequestResource::collection($orders)->response()->getData(true)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRadiologicalRequest $request)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $data = $request->validated();
        $data['doctor_id'] = $doctor->id;

        DB::beginTransaction();
        try
        {
            $order = RadiologicalRequest::create($data);
            DB::commit();
            return ApiResponse::successResponse(
                'Radiological request created successfully',
                200,
                ["id" => $order->id]
            );
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return ApiResponse::errorResponse(
                'Failed to create radiological request. Please try again later.',
                500
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $this->getAuthenticatedDoctor();
        $order = RadiologicalRequest::find($id);
        if(!$order)
        {
            return ApiResponse::errorResponse(
                'Radiological request not found',
                404
            );
        }

        return ApiResponse::successResponse(
            'Radiological request created successfully',
            200,
            new RadiologicalRequestResource($order)
            // $order
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $this->getAuthenticatedDoctor();
        $order = RadiologicalRequest::find($id);
        if(!$order)
        {
            return ApiResponse::errorResponse(
                'Radiological request not found',
                404
            );
        }

        return ApiResponse::successResponse(
            'Radiological request created successfully',
            200,
            new RadiologicalRequestResource($order)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRadiologicalRequest $request, $id)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $data = $request->validated();

        $order = RadiologicalRequest::find($id);
        if(!$order)
        {
            return ApiResponse::errorResponse(
                'Radiological request not found',
                404
            );
        }

        $data["doctor_id"] = $doctor->id;

        DB::beginTransaction();
        try
        {
            $order->update($data);
            
            DB::commit();
            return ApiResponse::successResponse(
                'Radiological request updated successfully',
                200,
                ["id" => $order->id]
            );
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            return ApiResponse::errorResponse(
                'Failed to update radiological request. Please try again later.',
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
        $order = RadiologicalRequest::find($id);
        if(!$order)
        {
            return ApiResponse::errorResponse(
                'Radiological request not found',
                404
            );
        }

        if ($order->radiologyReport()->exists())
        {
            return ApiResponse::errorResponse(
                'Cannot delete this request because a radiology report has already been issued for it.',
                400
            );
        }

        try
        {
            $order->delete();
            
            return ApiResponse::successResponse(
                'Radiological request deleted successfully',
                200
            );
        }
        catch (\Exception $e)
        {
            return ApiResponse::errorResponse(
                'An error occurred while deleting the request.',
                500
            );
        }
    }
}
