<?php

namespace App\Http\Requests\Quiz;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddQuizRequest extends FormRequest
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
            'name' => [
                'required',
                'max:100',
                Rule::unique('quizzes')->where(function ($query) {
                    $where_clause = "LOWER(name) = LOWER(?)";

                    return $query->whereRaw(
                        $where_clause,
                        [$this->get('name')]
                    );
                }),
            ],
            'description' => 'required',
            'user_id' => 'nullable|numeric|min:1|exists:users,id',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Name',
            'description' => 'Description',
            'user_id' => 'User',
        ];
    }
}
