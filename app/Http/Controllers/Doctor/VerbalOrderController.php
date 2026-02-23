<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StoreVerbalOrderRequest;
use App\Http\Requests\Doctor\UpdateVerbalOrderRequest;
use App\Http\Resources\VerbalOrderResource;
use App\Models\VerbalOrder;
use App\Traits\ApiResponse;
use App\Traits\HasDoctorContext;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VerbalOrderController extends Controller
{
    use HasDoctorContext;
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index($family_member_id)
    {
        $this->getAuthenticatedDoctor();
        $orders = VerbalOrder::with(['orderedByDoctor', 'recordedByNurse'])
            ->where('family_member_id', $family_member_id)
            ->latest() 
            ->paginate(5);

        if ($orders->isEmpty())
        {
            return ApiResponse::successResponse("No orders found for this family member", 200, []);
        }

        return ApiResponse::successResponse(
            "Latest 5 verbal orders retrieved successfully",
            200,
            VerbalOrderResource::collection($orders)->response()->getData(true)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVerbalOrderRequest $request)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $data = $request->validated();

        DB::beginTransaction();
        try 
        {
            $verbalOrder = VerbalOrder::create([
                "family_member_id" => $data["family_member_id"],
                "instructions" => $data["instructions"],
                "order_date_time" => $data["order_date_time"],
                "ordered_by_doctor_id" => $doctor->id,
            ]);

            DB::commit();
            return ApiResponse::successResponse(
                "Verbal order created successfully",
                200,
                ["order id" => $verbalOrder->id]
            );
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return ApiResponse::errorResponse("Something went wrong while creating the order", 500);
        }
    }

    public function confirm($id)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $order = VerbalOrder::find($id);
        if(!$order)
        {
            return ApiResponse::errorResponse("Order not found", 404);
        }

        if ($order->is_confirmed)
        {
            return ApiResponse::errorResponse("This order has already been confirmed", 400);
        }

        DB::beginTransaction();
        try
        {
            $order->update([
                'is_confirmed' => true,
                'confirmed_by_doctor_id' => $doctor['id'],
                'confirmation_date_time' => Carbon::now(),
            ]);
            DB::commit();
            
            return ApiResponse::successResponse(
                "Verbal order confirmed successfully",
                200,
                new VerbalOrderResource($order)
            );
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return ApiResponse::errorResponse("Something went wrong while confirming the order", 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $this->getAuthenticatedDoctor();
        $order = VerbalOrder::find($id);
        if (!$order)
        {
            return ApiResponse::errorResponse("Order not found", 404);
        }

        return ApiResponse::successResponse(
            "Order data retrieved",
            200,
            new VerbalOrderResource($order)
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->getAuthenticatedDoctor();
        $order = VerbalOrder::find($id);
        if (!$order)
        {
            return ApiResponse::errorResponse("Order not found", 404);
        }

        if ($order->is_confirmed)
        {
            return ApiResponse::errorResponse("Cannot edit a confirmed order", 400);
        }

        return ApiResponse::successResponse(
            "Order data retrieved",
            200,
            new VerbalOrderResource($order)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVerbalOrderRequest $request, $id)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $data = $request->validated();
        $order = VerbalOrder::find($id);
        if (!$order)
        {
            return ApiResponse::errorResponse("Order not found", 404);
        }

        if ($order->is_confirmed)
        {
            return ApiResponse::errorResponse("Cannot update a confirmed order", 400);
        }

        DB::beginTransaction();
        try
        {            
            $order->update([
                "instructions" => $data["instructions"],
                "order_date_time" => $data["order_date_time"],
                "ordered_by_doctor_id" => $doctor->id,
            ]);

            DB::commit();
            return ApiResponse::successResponse(
                "Verbal order updated successfully",
                200,
                new VerbalOrderResource($order)
            );
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return ApiResponse::errorResponse("Something went wrong during update", 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->getAuthenticatedDoctor();
        $order = VerbalOrder::find($id);
        if (!$order)
        {
            return ApiResponse::errorResponse("Order not found or already deleted", 404);
        }

        if ($order->is_confirmed)
        {
            return ApiResponse::errorResponse("Cannot delete a confirmed medical order for legal compliance", 400);
        }

        DB::beginTransaction();
        try
        {
            // بما إن الموديل فيه SoftDeletes، السطر ده هيملى خانة deleted_at فقط
            $order->delete();

            DB::commit();
            return ApiResponse::successResponse("Verbal order moved to trash successfully", 200);
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return ApiResponse::errorResponse("Something went wrong while deleting", 500);
        }
    }
}
