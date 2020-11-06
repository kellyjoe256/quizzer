<?php

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $password = 'password';
        User::insert([
            $this->data(
                'John Doe',
                'admin@example.com',
                $password,
                true
            ),
            $this->data(
                'Jane Doe',
                'demo@example.com',
                $password
            ),
        ]);
    }

    /**
     * User creation data
     *
     * @param string $name
     * @param string $email
     * @param string $password
     * @param bool $is_admin
     *
     * @return array
     */
    public function data($name, $email, $password, $is_admin = false)
    {
        return [
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'is_admin' => $is_admin,
            'created_at' => Carbon::now(),
        ];
    }
}
