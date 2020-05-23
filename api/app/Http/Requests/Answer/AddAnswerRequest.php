<?php

namespace App\Http\Requests\Answer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddAnswerRequest extends FormRequest
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
            'value' => [
                'required',
                'max:100',
                Rule::unique('answers')->where(function ($query) {
                    $where_clause = "
                        LOWER(value) = LOWER(?) AND question_id = ?
                    ";

                    return $query->whereRaw(
                        $where_clause,
                        [
                            $this->get('value'),
                            $this->get('question_id'),
                        ]
                    );
                }),
            ],
            'is_true' => 'required|boolean',
            'question_id' => 'required|numeric|min:1|exists:questions,id',
        ];
    }

    public function attributes()
    {
        return [
            'value' => 'Value',
            'is_true' => 'Truthy',
            'question_id' => 'Question',
        ];
    }
}
