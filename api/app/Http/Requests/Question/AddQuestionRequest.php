<?php

namespace App\Http\Requests\Question;

use App\Rules\IUnique;
use Illuminate\Foundation\Http\FormRequest;

class AddQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'text' => [
                'required',
                'max:255',
                (new IUnique(
                    'questions',
                    'Question',
                    [
                        'text' => $this->get('text'),
                        'quiz_id' => $this->get('quiz_id'),
                    ]
                )),
            ],
            'quiz_id' => 'required|numeric|min:1|exists:quizzes,id',
        ];
    }

    public function attributes()
    {
        return [
            'text' => 'Text',
            'quiz_id' => 'Quiz',
        ];
    }
}
