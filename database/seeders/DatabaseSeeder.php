<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
{
    $this->call([
        UserSeeder::class,     // so users 1,2,3 exist
        ProductSeeder::class,  // so products 5–17 exist
        OrderSeeder::class,    // now you can safely attach products
    ]);
}

}
