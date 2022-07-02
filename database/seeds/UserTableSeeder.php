<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'email' => 'minhtam.ub9@gmail.com',
                'password' => Hash::make('12345678'),
                'first_name' => 'Minh',
                'last_name' => 'Tam',
                'phone_number' => '12345678'
            ]
        ]);
    }
}
