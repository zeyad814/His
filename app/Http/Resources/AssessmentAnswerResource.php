<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssessmentAnswerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'question_id'   => $this->assessment_question_id,
            'category'      => $this->question->category,
            'question_text' => $this->question->question_text,
            'key_name'      => $this->question->key_name,
            'input_type'    => $this->question->input_type,
            'options'       => $this->when($this->question->options, $this->question->options), 
            'answer_value'  => $this->answer_value,
        ];
    }
}
