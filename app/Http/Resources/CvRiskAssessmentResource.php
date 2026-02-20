<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CvRiskAssessmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $isEdit1 = $request->routeIs('doctor.cv-risk.editStep1');
        $isEdit2 = $request->routeIs('doctor.cv-risk.editStep2');
        $isEdit3 = $request->routeIs('doctor.cv-risk.editStep3');
        $isShow  = $request->routeIs('doctor.cv-risk.show');
        $isIndex = $request->routeIs('doctor.cv-risk.index');
        
        return [
            'id' => $this->id,
            'family member id' => $this->family_member_id,
            'doctor name' => $this->doctor->user->name,

            'assessment date' =>$this->when(
                $isEdit1 || $isIndex || $isShow,
                $this->assessment_date
            ),
            'hypertension' => $this->when(
                $isEdit1 || $isShow,
                $this->hypertension
            ),
            'dm' => $this->when(
                $isEdit1 || $isShow,
                $this->dm
            ),
            'obesity' => $this->when(
                $isEdit1 || $isShow,
                $this->obesity
            ),
            'smoking' => $this->when(
                $isEdit1 || $isShow,
                $this->smoking
            ),
            'family history cardiac' => $this->when(
                $isEdit1 || $isShow,
                $this->family_history_cardiac
            ),

            'bp' => $this->when(
                $isEdit2 || $isShow,
                $this->bp
            ),
            'height' => $this->when(
                $isEdit2 || $isShow,
                $this->height
            ),
            'weight' => $this->when(
                $isEdit2 || $isShow,
                $this->weight
            ),
            'cholesterol total' => $this->when(
                $isEdit2 || $isShow,
                $this->cholesterol_total
            ),
            'ldl level' => $this->when(
                $isEdit2 || $isShow,
                $this->ldl_level
            ),

            'cv risk level' =>  $this->when(
                $isEdit3 || $isShow,
                $this->cv_risk_level
            ),
            'management plan' =>  $this->when(
                $isEdit3 || $isShow,
                $this->management_plan
            ),
            'referral to' =>  $this->when(
                $isEdit3 || $isShow,
                $this->referral_to
            ),
            'follow up date' =>  $this->when(
                $isEdit3 || $isShow,
                $this->follow_up_date
            ),

            'created at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
        ];
    }
}
