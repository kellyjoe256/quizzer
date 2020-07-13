<?php

namespace App\Http\Requests\Answer;

use App\Rules\IUnique;

class EditAnswerRequest extends AddAnswerRequest
{
    public function rules()
    {
        $rules = parent::rules();
        $rules['value'] = [
            'required',
            'max:255',
            (new IUnique(
                'answers',
                'Answer',
                [
                    'value' => $this->get('value'),
                    'question_id' => $this->get('question_id'),
                ],
                $this->route('id')
            )),
        ];

        return $rules;
    }
}
