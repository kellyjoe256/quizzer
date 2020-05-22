<?php

use App\User;
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

        User::insert([
            'name' => 'Wafukho Kelly Joseph',
            'email' => 'kelly@example.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
            'created_at' => \Carbon\Carbon::now(),
        ]);
    }
}
