<?php

namespace App\Http\Requests\Question;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
                Rule::unique('questions')->where(function ($query) {
                    $where_clause = "LOWER(text) = LOWER(?) AND quiz_id = ?";

                    return $query->whereRaw(
                        $where_clause,
                        [
                            $this->get('text'),
                            $this->get('quiz_id'),
                        ]
                    );
                }),
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
