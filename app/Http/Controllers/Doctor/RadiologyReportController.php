<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StoreRadiologyReport;
use App\Http\Requests\Doctor\UpdateRadiologyReport;
use App\Http\Resources\RadiologyReportResource;
use App\Models\RadiologyReport;
use App\Traits\ApiResponse;
use App\Traits\HasDoctorContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RadiologyReportController extends Controller
{
    use HasDoctorContext;
    use ApiResponse;

    /**
     * Store a newly created radiology report.
     */
    public function store(StoreRadiologyReport $request)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $data = $request->validated();
        $data['doctor_id'] = $doctor->id;

        // Handle file upload if present
        // if ($request->hasFile('report_file'))
        // {
        //     $data['report_file'] = $request->file('report_file')->store('radiology_reports', 'public');
        // }

        DB::beginTransaction();
        try
        {
            $report = RadiologyReport::create($data);
            DB::commit();

            return ApiResponse::successResponse(
                'Radiology report has been created successfully.',
                201,
                ["id" => $report->id]
            );
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            // Clean up uploaded file if database insertion fails
            // if (isset($data['report_file'])) 
            // {
            //     Storage::disk('public')->delete($data['report_file']);
            // }

            return ApiResponse::errorResponse(
                'An error occurred while creating the report. Please try again.',
                500
            );
        }
    }

    /**
     * Display the specified radiology report.
     */
    public function show($id)
    {
        $this->getAuthenticatedDoctor();
        $report = RadiologyReport::find($id);
        if (!$report)
        {
            return ApiResponse::errorResponse(
                'The requested radiology report was not found.',
                404
            );
        }

        return ApiResponse::successResponse(
            'Radiology report details retrieved successfully.',
            200,
            new RadiologyReportResource($report)
        );
    }

    /**
     * Show the form for editing the specified report.
     */
    public function edit($id)
    {
        $this->getAuthenticatedDoctor();
        $report = RadiologyReport::find($id);
        if (!$report)
        {
            return ApiResponse::errorResponse(
                'Unable to locate the report for editing.',
                404
            );
        }

        return ApiResponse::successResponse(
            'Report data fetched for modification.',
            200,
            new RadiologyReportResource($report)
        );
    }

    /**
     * Update the specified radiology report in storage.
     */
    public function update(UpdateRadiologyReport $request, $id)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $data = $request->validated();
        $data["doctor_id"] = $doctor->id;
        $report = RadiologyReport::find($id);
        if (!$report)
        {
            return ApiResponse::errorResponse(
                'Unable to process update: The specified radiology report record could not be found.',
                404
            );
        }

        // Handle file update logic
        // if ($request->hasFile('report_file'))
        // {
        //     // Delete old file if it exists
        //     if ($report->report_file)
        //     {
        //         Storage::disk('public')->delete($report->report_file);
        //     }
        //     $data['report_file'] = $request->file('report_file')->store('radiology_reports', 'public');
        // }

        DB::beginTransaction();
        try
        {
            $report->update($data);
            DB::commit();

            return ApiResponse::successResponse(
                'Radiology report updated successfully.',
                200,
                new RadiologyReportResource($report->fresh())
            );
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return ApiResponse::errorResponse(
                'Failed to update the report. System encountered an unexpected error.',
                500
            );
        }
    }

    /**
     * Remove the specified radiology report.
     */
    /**public function destroy($id)
    {
        $this->getAuthenticatedDoctor();
        $report = RadiologyReport::find($id);

        if (!$report)
        {
            return ApiResponse::errorResponse(
                'The report could not be found for deletion.',
                404
            );
        }

        try {
            // Delete physical file before deleting record
            // if ($report->report_file)
            // {
            //     Storage::disk('public')->delete($report->report_file);
            // }
            
            $report->delete();

            return ApiResponse::successResponse(
                'Radiology report and associated files deleted successfully.',
                200
            );
        }
        catch (\Exception $e)
        {
            return ApiResponse::errorResponse(
                'Error occurred during deletion process.',
                500
            );
        }
    }
    */
}