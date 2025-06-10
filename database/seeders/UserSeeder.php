<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'id'         => 5,
                'name'       => 'hanane',
                'email'      => 'hanane@example.com',
                'password'   => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => 7,
                'name'       => 'kamal',
                'email'      => 'kamal@example.com',
                'password'   => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id'         => 10,
                'name'       => 'hajar',
                'email'      => 'hajar@example.com',
                'password'   => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
             [
                'id'         => 8,
                'name'       => 'nassima',
                'email'      => 'nassima@example.com',
                'password'   => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
             ],
              [
                'id'         => 15,
                'name'       => 'siham',
                'email'      => 'siham@example.com',
                'password'   => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
              ],
               [
                'id'         => 20,
                'name'       => 'mohamed',
                'email'      => 'mohamed@example.com',
                'password'   => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
               ],
                [
                'id'         => 19,
                'name'       => 'rania',
                'email'      => 'rania@example.com',
                'password'   => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
