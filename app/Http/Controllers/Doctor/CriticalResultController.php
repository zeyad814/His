<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\ReTestCriticalResultRequest;
use App\Http\Requests\Doctor\StoreCriticalResultRequest;
use App\Http\Requests\Doctor\UpdateCriticalResultRequest;
use App\Http\Resources\CriticalResultResource;
use App\Models\CriticalResult;
use App\Models\Doctor;
use App\Models\Visit;
use App\Notifications\CriticalResultNotification;
use App\Notifications\CriticalResultRejectedNotification;
use App\Traits\ApiResponse;
use App\Traits\HasDoctorContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CriticalResultController extends Controller
{
    use ApiResponse, HasDoctorContext;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->getAuthenticatedDoctor();
    }

    public function getReceivingDoctors()
    {
        $doctor = $this->getAuthenticatedDoctor();

        // بنجيب الأطباء اللي في الأقسام الطبية (مش بتوع المعمل)
        $doctors = Doctor::with(["user:name,userable_id,userable_type"])
            ->select('id', 'specialization')
            ->where("health_unit_id", $doctor->health_unit_id)
            ->get()
            ->map(function ($doc) {
                return [
                    'id' => $doc->id,
                    'specialization' => $doc->specialization,
                    // بنوصل للاسم من خلال العلاقة، ولو مش موجود بنحط قيمة افتراضية
                    'name' => $doc->user ? $doc->user->name : null,
                ];
            });

        return ApiResponse::successResponse(
            'Doctors list retrieved',
            200,
            $doctors
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCriticalResultRequest $request)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $data = $request->validated();
        $data["notifier_id"] = $doctor->id;

        $visit = Visit::find($data["visit_id"]);
        if($visit->visit_type != "زيارة دورية")
        {
            return ApiResponse::errorResponse(
                "Action Denied: Critical results can only be logged for 'Regular Visits'. Please verify the visit type.",
                422
            );
        }

        DB::beginTransaction();
        try
        {
            $result = CriticalResult::create($data);
            if (!empty($result->recipient_id))
            {
                $recipient = Doctor::find($result->recipient_id);
                if ($recipient)
                {
                    $recipient->notify(new CriticalResultNotification($result));
                }
            }

            DB::commit();
            return ApiResponse::successResponse(
                'Critical result recorded and notification sent to the recipient doctor successfully.',
                200,
                ['id' => $result->id]
            );
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return ApiResponse::errorResponse(
                'System error: Failed to log the critical result. Please retry immediately or contact IT support.',
                500
            );
        }
    }

    public function getMyNotifications()
    {
        $doctor = $this->getAuthenticatedDoctor();

        // بيجيب 10 إشعارات بس في كل مرة
        $notifications = $doctor->notifications()
            ->latest()
            ->simplePaginate(10);

        return ApiResponse::successResponse(
            'Notifications retrieved successfully',
            200,
            $notifications
        );
    }

    public function markAsRead($id)
    {
        $doctor = $this->getAuthenticatedDoctor();

        // بنبحث عن الإشعار جوه إشعارات الدكتور ده بس (للحماية)
        $notification = $doctor->notifications()->where('id', $id)->first();
        if (!$notification)
        {
            return ApiResponse::errorResponse('Notification not found', 404);
        }

        $notification->markAsRead();

        return ApiResponse::successResponse(
            'Notification marked as read successfully',
            200
        );
    }

    public function respondToResult(Request $request, $id)
    {
        $doctor = $this->getAuthenticatedDoctor();

        $request->validate([
            'is_accepted'   => 'required|boolean',
            'doctor_action' => 'required_if:is_accepted,1|string|nullable', 
        ]);

        $result = CriticalResult::with(['notifier', 'familyMember'])->find($id);
        if (!$result)
        {
            return ApiResponse::errorResponse(
                'Critical result not found',
                404
            );
        }

        if ($result->recipient_id !== $doctor->id)
        {
            return ApiResponse::errorResponse(
                'You are not authorized to update this result',
                403
            );
        }

        if ($result->is_accepted === 1 || $result->is_accepted === true)
        {
            return ApiResponse::errorResponse(
                'Action Denied: This critical result has already been accepted and finalized. No further modifications or re-tests are allowed.',
                422
            );
        }

        DB::beginTransaction();
        try
        {
            $result->update([
                'is_accepted' => $request->is_accepted,
                'doctor_action' => $request->doctor_action ?? $result->doctor_action,
                'doctor_id' => $doctor->id,
            ]);

            // لو الدكتور رفض النتيجة (false)
            if ($request->is_accepted == false)
            {
                $notifier = $result->notifier; // الدكتور اللي بلغ بالأصل
                if ($notifier)
                {
                    $notifier->notify(new CriticalResultRejectedNotification($result));
                }
            }

            DB::commit();
            return ApiResponse::successResponse(
                $request->is_accepted ? 'Result accepted' : 'Result rejected and notifier notified to re-test',
                200,
                new CriticalResultResource($result)
            );

        }
        catch (\Exception $e)
        {
            DB::rollback();
            return ApiResponse::errorResponse(
                'Failed to update result status',
                500
            );
        }
    }

    public function reTestResult(ReTestCriticalResultRequest $request, $id)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $data = $request->validated();
        $data["is_accepted"] = null;

        $result = CriticalResult::find($id);
        if (!$result)
        {
            return ApiResponse::errorResponse('Critical result not found', 404);
        }

        // التأكد إن اللي بيعدل هو الـ Notifier الأصلي
        if ($result->notifier_id !== $doctor->id)
        {
            return ApiResponse::errorResponse(
                'Critical result not found',
                404
            );
        }

        if ($result->is_accepted === 1 || $result->is_accepted === true)
        {
            return ApiResponse::errorResponse(
                'Action Denied: This critical result has already been accepted and finalized. No further modifications or re-tests are allowed.',
                422
            );
        }

        $data["second_notifier_id"] = $result->notifier_id;
        $data["second_recipient_id"] = $result->recipient_id;

        DB::beginTransaction();
        try
        {
            $result->update($data);

            // إشعار للدكتور المستلم الجديد
            $recipient = Doctor::find($data['second_recipient_id']);
            if ($recipient)
            {
                $recipient->notify(new CriticalResultNotification($result));
            }

            DB::commit();
            return ApiResponse::successResponse(
                'Re-test recorded. Notification sent to the recipient.',
                200,
                new CriticalResultResource($result)
            );

        }
        catch (\Exception $e)
        {
            DB::rollback();
            return ApiResponse::errorResponse('Failed to record re-test.' . $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $this->getAuthenticatedDoctor();
        $result = CriticalResult::find($id);
        if (!$result)
        {
            return ApiResponse::errorResponse(
                'Critical result not found',
                404
            );
        }

        return ApiResponse::successResponse(
            'Critical result retrieved successfully',
            200,
            new CriticalResultResource($result)
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCriticalResultRequest $request, $id)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $data = $request->validated();
        $data["notifier_id"] = $doctor->id;

        $result = CriticalResult::find($id);
        if (!$result)
        {
            return ApiResponse::errorResponse(
                'Critical result not found',
                404
            );
        }
        
        if ($result->is_accepted === 1 || $result->is_accepted === true)
        {
            return ApiResponse::errorResponse(
                'Action Denied: This critical result has already been accepted and finalized. No further modifications or re-tests are allowed.',
                422
            );
        }

        DB::beginTransaction();
        try
        {
            $result->update($data);
            
            DB::commit();
            return ApiResponse::successResponse(
                'Critical result updated successfully.',
                200,
                new CriticalResultResource($result)
            );
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return ApiResponse::errorResponse('Update failed due to a system error.', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->getAuthenticatedDoctor();
        $result = CriticalResult::find($id);
        if (!$result)
        {
            return ApiResponse::errorResponse('Critical result not found', 404);
        }

        if ($result->is_accepted === 1 || $result->is_accepted === true)
        {
            return ApiResponse::errorResponse(
                'Deletion Denied: This critical result has been accepted and finalized. It cannot be deleted for medical auditing purposes.',
                422
            );
        }

        // if ($result->notifier_id !== $doctor->id) {
        //     return ApiResponse::errorResponse('Unauthorized: You can only delete results you have created.', 403);
        // }

        DB::beginTransaction();
        try
        {
            DB::table('notifications')
                ->whereJsonContains('data->critical_result_id', (int)$result->id)
                ->orWhereJsonContains('data->id', (int)$result->id)
                ->delete();

            $result->delete();

            DB::commit();
            return ApiResponse::successResponse(
                'Critical result deleted successfully.',
                200
            );
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return ApiResponse::errorResponse(
                'System error: Failed to delete the record.',
                500
            );
        }
    }
}
