<?php

namespace App\Http\Requests\User;

use App\Rules\PasswordRule;
use Illuminate\Validation\Rule;

class EditUserRequest extends AddUserRequest
{
    public function rules()
    {
        $rules = parent::rules();

        $rules['email'] = [
            'required',
            'max:50',
            'email',
            Rule::unique('users')->where(function ($query) {
                $where_clause = "LOWER(email) = LOWER(?) AND id <> ?";

                return $query->whereRaw(
                    $where_clause,
                    [
                        $this->get('email'),
                        $this->route('id'),
                    ]
                );
            }),
        ];
        $rules['password'] = [
            'nullable',
            'min:8',
            new PasswordRule(),
        ];

        return $rules;
    }
}
