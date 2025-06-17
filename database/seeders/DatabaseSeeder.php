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
        UserSeeder::class, 
        CategorySeeder::class,    
        ProductSeeder::class,  // so products 5–17 exist
        OrderSeeder::class,    // now you can safely attach products
    ]);
}

}
