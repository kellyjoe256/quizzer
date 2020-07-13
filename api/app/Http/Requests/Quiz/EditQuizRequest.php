<?php

namespace App\Http\Requests\Quiz;

use App\Rules\IUnique;

class EditQuizRequest extends AddQuizRequest
{
    public function rules()
    {
        $rules = parent::rules();
        $rules['name'] = [
            'required',
            'max:100',
            (new IUnique(
                'quizzes',
                'Name',
                [
                    'name' => $this->get('name'),
                ],
                $this->route('id')
            )),
        ];

        return $rules;
    }
}
