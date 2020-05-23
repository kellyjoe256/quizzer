<?php

namespace App\Http\Requests\Answer;

use Illuminate\Validation\Rule;

class EditAnswerRequest extends AddAnswerRequest
{
    public function rules()
    {
        $rules = parent::rules();

        $rules['value'] = [
            'required',
            'max:255',
            Rule::unique('answers')->where(function ($query) {
                $where_clause = "
                    LOWER(value) = LOWER(?) AND question_id = ? AND id <> ?
                ";

                return $query->whereRaw(
                    $where_clause,
                    [
                        $this->get('value'),
                        $this->get('question_id'),
                        $this->route('id'),
                    ]
                );
            }),
        ];

        return $rules;
    }
}
