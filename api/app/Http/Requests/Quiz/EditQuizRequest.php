<?php

namespace App\Http\Requests\Quiz;

use Illuminate\Validation\Rule;

class EditQuizRequest extends AddQuizRequest
{
    public function rules()
    {
        $rules = parent::rules();

        $rules['name'] = [
            'required',
            'max:100',
            Rule::unique('quizzes')->where(function ($query) {
                $where_clause = "LOWER(name) = LOWER(?) AND id <> ?";

                return $query->whereRaw(
                    $where_clause,
                    [
                        $this->get('name'),
                        $this->route('id'),
                    ]
                );
            }),
        ];

        return $rules;
    }
}
