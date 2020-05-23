<?php

namespace App\Http\Resources\Answer;

use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'value' => $this->value,
            'is_true' => $this->is_true ? true : false,
            'created_at' => optional($this->created_at)->format('F jS, Y'),
            'question_id' => $this->question_id,
        ];
    }
}
