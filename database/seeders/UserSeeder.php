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
                
                'name'       => 'amine',
                'email'      => 'amine@example.com',
                'password'   => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
           
                'name'       => 'salah',
                'email'      => 'salah@example.com',
                'password'   => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
              
                'name'       => 'mryem',
                'email'      => 'mryem@example.com',
                'password'   => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
             [
            
                'name'       => 'asma',
                'email'      => 'asma@example.com',
                'password'   => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
             ],
              [
             
                'name'       => 'fatima',
                'email'      => 'fatima@example.com',
                'password'   => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
              ],
               [
              
                'name'       => 'ahmed',
                'email'      => 'ahmed@example.com',
                'password'   => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
               ],
                [
               
                'name'       => 'youssef',
                'email'      => 'youssef@example.com',
                'password'   => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
                ],
                [
               
                'name'       => 'khadija',
                'email'      => 'khadija@example.com',
                'password'   => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
                ],
                [
               
                'name'       => 'amal',
                'email'      => 'amal@example.com',
                'password'   => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
                ],
                [
               
               "name"      =>   'hanane',
                'email'      => 'hanane@example.com',
                'password'   => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
                ],
                [
               
                'name'       => 'ali',
                'email'      => 'ali@example.com',
                'password'   => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
                ],
        ]);
    }
}
