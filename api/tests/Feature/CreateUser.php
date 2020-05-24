<?php

namespace Tests\Feature;

use App\User;

trait CreateUser
{
    private $is_admin = false;

    public function get_is_admin()
    {
        return $this->is_admin;
    }

    public function set_is_admin($is_admin)
    {
        $this->is_admin = $is_admin;
    }

    private function user_data()
    {
        return [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'password' => '12345@Pa55!',
            'is_admin' => $this->get_is_admin(),
        ];
    }

    private function user_keys()
    {
        return collect($this->user_data())
            ->except('password')
            ->keys()
            ->toArray();
    }

    private function create_user(array $new_user_data = [])
    {
        $data = count($new_user_data) ? $new_user_data : $this->user_data();

        User::create(
            array_merge(
                $data,
                ['password' => collect($data)->get('password', '')]
            )
        );

        return collect($data)->only(['email', 'password'])->toArray();
    }

    private function create_admin_user()
    {
        $this->set_is_admin(true);

        return $this->create_user();
    }

    private function login($as_admin = false)
    {
        $credentials = $as_admin
        ? $this->create_admin_user()
        : $this->create_user();

        return auth()->attempt($credentials);
    }
}
