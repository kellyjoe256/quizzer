<?php

namespace App\Http\Requests\User;

use App\Rules\IUnique;
use App\Rules\PasswordRule;

class EditUserRequest extends AddUserRequest
{
    public function rules()
    {
        $rules = parent::rules();
        $rules['email'] = [
            'required',
            'max:50',
            'email',
            (new IUnique(
                'users',
                'Email',
                [
                    'email' => $this->get('email'),
                ],
                $this->route('id')
            )),
        ];
        $rules['password'] = [
            'nullable',
            'min:8',
            new PasswordRule(),
        ];

        return $rules;
    }
}
