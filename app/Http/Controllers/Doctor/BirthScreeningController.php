<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\StoreBirthScreeningRequest;
use App\Http\Requests\Doctor\StoreGrowthVisitRequest;
use App\Http\Requests\Doctor\StoreSpecialCasesRequest;
use App\Http\Requests\Doctor\UpdateGrowthVisitRequest;
use App\Models\BirthScreening;
use App\Models\GrowthVisit;
use App\Traits\ApiResponse;
use App\Traits\HasDoctorContext;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BirthScreeningController extends Controller
{
    use HasDoctorContext;
    use ApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBirthScreeningRequest $request)
    {
        $data = $request->validated();
        $doctor = $this->getAuthenticatedDoctor();

        DB::beginTransaction();
        try
        {
            $screening = BirthScreening::updateOrCreate(
                ['family_member_id' => $data['family_member_id']],
                $data
            );

            DB::commit();
            return ApiResponse::successResponse('Birth screening and neonatal data recorded successfully', 200, ['id' => $screening->id]);
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return ApiResponse::errorResponse('Failed to save screening data. Please try again later', 500);
        }
    }

    public function storeGrowthVisit(StoreGrowthVisitRequest $request)
    {
        $data = $request->validated();
        $doctor = $this->getAuthenticatedDoctor();
        $age = $data['age_stage'];
        if (in_array($age, ['under_2_months', '2', '4', '6']))
        {
            unset(
                $data['natural_breastfeeding'],
                $data['other_foods'],
                $data['hemoglobin_level']
            );
        }
        elseif ($age == '9')
        {
            unset(
                $data['exclusive_breastfeeding'],
                $data['supplementary_feeding'],
                $data['bottle_feeding'],
                $data['cup_spoon_feeding'],
                $data['hemoglobin_level']
            );
        }
        elseif (in_array($age, ['12', '18', '24']))
        {
            unset(
                $data['exclusive_breastfeeding'],
                $data['supplementary_feeding'],
                $data['bottle_feeding'],
                $data['cup_spoon_feeding']
            );
        }
        elseif (in_array($age, ['36', '48', '60']))
        {
            unset(
                $data['exclusive_breastfeeding'],
                $data['supplementary_feeding'],
                $data['bottle_feeding'],
                $data['cup_spoon_feeding'],
                $data['natural_breastfeeding']
            );
        }

        DB::beginTransaction();
        try
        {
            $visit = GrowthVisit::create($data);
            DB::commit();
            return ApiResponse::successResponse('Growth visit recorded successfully', 200, ['birth_screening_id' => $visit->birth_screening_id]);
        }
        catch(\Exception $e)
        {
            DB::rollback();
            // return response()->json(['error' => $e->getMessage()]);
            return ApiResponse::errorResponse('Failed to save screening data. Please try again later', 500);
        }
    }

    public function storeSpecialCases(StoreSpecialCasesRequest $request)
    {
        $data = $request->validated();
        $doctor = $this->getAuthenticatedDoctor();

        DB::beginTransaction();
        try {
            $specialCases = BirthScreening::updateOrCreate(
                ['family_member_id' => $data['family_member_id']],
                $data
            );

            DB::commit();
            return ApiResponse::successResponse('Special health conditions and developmental data updated successfully', 200, [
                'birth_screening_id' => $specialCases->id
            ]);

        }
        catch (\Exception $e)
        {
            DB::rollback();
            return ApiResponse::errorResponse("Unable to save health records at the moment. Please try again", 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($family_member_id)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $screening = BirthScreening::where('family_member_id', $family_member_id)->first();
        if (!$screening)
        {
            return ApiResponse::errorResponse('No screening records found for this member.', 404);
        }

        // $growthVisits = GrowthVisit::where('birth_screening_id', $screening->id)->paginate(3);
        $growthVisits = GrowthVisit::where('birth_screening_id', $screening->id)
            ->latest()
            ->paginate(3)
            ->through(function ($visit) {
                return [
                    "id" => $visit->id,
                    'visit_date' => $visit->visit_date,
                    'age_stage' => $visit->age_stage,
                    'weight_kg' => $visit->weight_kg,
                    'height_cm' => $visit->height_cm,
                    'head_circumference_cm' => $visit->head_circumference_cm,
                    'use_pacifier' => (bool) $visit->use_pacifier,
                    'exclusive_breastfeeding' => (bool) $visit->exclusive_breastfeeding,
                    'supplementary_feeding' => (bool) $visit->supplementary_feeding,
                    'bottle_feeding' => (bool) $visit->bottle_feeding,
                    'cup_spoon_feeding' => (bool) $visit->cup_spoon_feeding,
                    'natural_breastfeeding' => (bool) $visit->natural_breastfeeding,
                ];
            });
        $responseData = [
            'screening_info' => $screening->makeHidden(['created_at', 'updated_at']), // إخفاء الحقول غير الضرورية
            'growth_visits' => $growthVisits->items(), // الزيارات الثلاث الحالية
            'pagination' => [
                'total' => $growthVisits->total(),
                'count' => $growthVisits->count(),
                'per_page' => $growthVisits->perPage(),
                'current_page' => $growthVisits->currentPage(),
                'total_pages' => $growthVisits->lastPage(),
            ]
        ];

        return ApiResponse::successResponse(
            'Birth screening and growth visit data retrieved successfully',
            200,
            $responseData
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($family_member_id)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $screening = BirthScreening::where('family_member_id', $family_member_id)->first();
        if (!$screening)
        {
            return ApiResponse::errorResponse('No birth screening record found for this family member.', 404);
        }

        $screening->makeHidden([
            'sensory_defects',
            'speech_difficulties',
            'growth_retardation',
            'autism',
            'genetic_diseases',
            'allergies',
            'other_special_cases',
            'special_cases_medications',
            'family_member_id',
            'created_at',
            'updated_at'
        ]);
        return ApiResponse::successResponse('Birth screening data retrieved successfully', 200, $screening);
    }

    public function editGrowthVisit($id)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $growthVisit = GrowthVisit::where('id', $id)->first();
        if (!$growthVisit)
        {
            return ApiResponse::errorResponse('No growth data found for this visit.', 404);
        }

        $growthVisit->makeHidden([
            'family_member_id',
            'birth_screening_id',
            'visit_id',
            'created_at',
            'updated_at'
        ]);
        return ApiResponse::successResponse(
            'Growth visit data retrieved successfully',
            200,
            $growthVisit
        );
    }

    public function editSpecialCases($family_member_id)
    {
        $doctor = $this->getAuthenticatedDoctor();
        $screening = BirthScreening::where('family_member_id', $family_member_id)->first();
        if (!$screening)
        {
            return ApiResponse::errorResponse('No special cases found for this child.', 404);
        }

        $data = $screening->only([
            'id',
            'sensory_defects',
            'speech_difficulties',
            'growth_retardation',
            'autism',
            'genetic_diseases',
            'allergies',
            'other_special_cases',
            'special_cases_medications'
        ]);

        return ApiResponse::successResponse('Special cases data retrieved successfully', 200, $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateGrowthVisit(UpdateGrowthVisitRequest $request, $id)
    {
        $data = $request->validated();
        $doctor = $this->getAuthenticatedDoctor();
        $growthVisit = GrowthVisit::find($id);
        if (!$growthVisit)
        {
            return ApiResponse::errorResponse('Growth record not found.', 404);
        }

        $age = $data['age_stage'];
        if (in_array($age, ['under_2_months', '2', '4', '6']))
        {
            $data['natural_breastfeeding'] = null;
            $data['other_foods'] = null;
            $data['hemoglobin_level'] = null;
        }
        elseif ($age == '9')
        {
            $data['exclusive_breastfeeding'] = null;
            $data['supplementary_feeding'] = null;
            $data['bottle_feeding'] = null;
            $data['cup_spoon_feeding'] = null;
            $data['hemoglobin_level'] = null;
        }
        elseif (in_array($age, ['12', '18', '24']))
        {
            $data['exclusive_breastfeeding'] = null;
            $data['supplementary_feeding'] = null;
            $data['bottle_feeding'] = null;
            $data['cup_spoon_feeding'] = null;
        }
        elseif (in_array($age, ['36', '48', '60']))
        {
            $data['exclusive_breastfeeding'] = null;
            $data['supplementary_feeding'] = null;
            $data['bottle_feeding'] = null;
            $data['cup_spoon_feeding'] = null;
            $data['natural_breastfeeding'] = null;
        }

        DB::beginTransaction();
        try
        {
            $growthVisit->update($data);

            DB::commit();
            return ApiResponse::successResponse('Growth visit updated successfully', 200, [
                'id' => $growthVisit->id
            ]);
        }
        catch (\Exception $e)
        {
            DB::rollback();
            return ApiResponse::errorResponse("Unable to update growth records. Please ensure all required health indicators are filled correctly.", 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
