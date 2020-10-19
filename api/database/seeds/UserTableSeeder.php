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

        User::insert([
            [
                'name' => 'John Doe',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'is_admin' => true,
                'created_at' => Carbon::now(),
            ],
            [
                'name' => 'Jane Doe',
                'email' => 'demo@example.com',
                'password' => bcrypt('password'),
                'is_admin' => false,
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
