<?php

namespace App\Http\Requests\Quiz;

use App\Rules\IUnique;
use Illuminate\Foundation\Http\FormRequest;

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
                (new IUnique(
                    'quizzes',
                    'Name',
                    [
                        'name' => $this->get('name'),
                    ]
                )),
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
