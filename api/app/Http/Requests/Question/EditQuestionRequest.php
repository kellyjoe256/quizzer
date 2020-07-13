<?php

namespace App\Http\Requests\Question;

use App\Rules\IUnique;

class EditQuestionRequest extends AddQuestionRequest
{
    public function rules()
    {
        $rules = parent::rules();
        $rules['text'] = [
            'required',
            'max:255',
            (new IUnique(
                'questions',
                'Question',
                [
                    'text' => $this->get('text'),
                    'quiz_id' => $this->get('quiz_id'),
                ],
                $this->route('id')
            )),
        ];

        return $rules;
    }
}
