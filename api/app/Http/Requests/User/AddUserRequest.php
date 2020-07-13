<?php

namespace App\Http\Requests\User;

use App\Rules\IUnique;
use App\Rules\PasswordRule;
use Illuminate\Foundation\Http\FormRequest;

class AddUserRequest extends FormRequest
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
            'name' => 'required|max:100',
            'email' => [
                'required',
                'max:50',
                'email',
                (new IUnique(
                    'users',
                    'Email',
                    [
                        'email' => $this->get('email'),
                    ]
                )),
            ],
            'password' => [
                'required',
                'min:8',
                new PasswordRule(),
            ],
            'is_admin' => 'nullable|boolean',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'is_admin' => 'Is Admin',
        ];
    }
}
