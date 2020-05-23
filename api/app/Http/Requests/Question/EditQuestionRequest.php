<?php

namespace App\Http\Requests\Question;

use Illuminate\Validation\Rule;

class EditQuestionRequest extends AddQuestionRequest
{
    public function rules()
    {
        $rules = parent::rules();

        $rules['text'] = [
            'required',
            'max:255',
            Rule::unique('questions')->where(function ($query) {
                $where_clause = "
                    LOWER(text) = LOWER(?) AND quiz_id = ? AND id <> ?
                ";

                return $query->whereRaw(
                    $where_clause,
                    [
                        $this->get('text'),
                        $this->get('quiz_id'),
                        $this->route('id'),
                    ]
                );
            }),
        ];

        return $rules;
        // return [
        //     'name' => 'required|max:100|unique:quizzes',
        //     'description' => 'required',
        //     'user_id' => 'nullable|numeric|min:1|exists:users,id',
        // ];
    }
}
