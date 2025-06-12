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
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}