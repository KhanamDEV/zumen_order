<?php

use Illuminate\Database\Seeder;

class WorkerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('workers')->insert([
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
