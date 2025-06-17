<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Office'],
            ['name' => 'Smartphones'],
            ['name' => 'Electronics'],
            ['name' => 'Furniture'],
            ['name' => 'Kitchen'],
            ['name' => 'Sports'],
            ['name' => 'Toys'],
            ['name' => 'Books'],
            ['name' => 'Clothing'],
            ['name' => 'Beauty'],
            ['name' => 'Automotive'],
            ['name' => 'Gardening'],
            ['name' => 'Health'],
            ['name' => 'Pet Supplies'],
            ['name' => 'Music'],
            ['name' => 'Video Games'],
            ['name' => 'Jewelry'],
            ['name' => 'Tools'],
            ['name' => 'Travel'],
            ['name' => 'Home Decor'],
            ['name' => 'Baby Products'],
            ['name' => 'Outdoor'],
          
           
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}