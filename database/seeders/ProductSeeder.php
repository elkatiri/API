<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ProductSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                "name" => "Sofa",
                "description" => "Comfortable sofa",
                "price" => 299.99,
                "quantity" => 10,
                "discount" => 10,
                "discount_expires_at" => "2025-12-31",
                "category_id" => 1,
                "images" => ["images/img1.png", "images/img3.png"]
            ],
            [
                "name" => "Office Chair",
                "description" => "Ergonomic office chair",
                "price" => 149.99,
                "quantity" => 5,
                "discount" => 15,
                "discount_expires_at" => "2025-11-30",
                "category_id" => 1,
                "images" => ["images/img4.png", "images/img5.png"]
            ],
            [
                "name" => "iPhone 14 Pro",
                "description" => "Apple iPhone 14 Pro - 128GB, Deep Purple",
                "price" => 999.99,
                "quantity" => 15,
                "discount" => 5,
                "discount_expires_at" => "2025-12-15",
                "category_id" => 3,
                "images" => ["images/img2.png", "images/imag1.png"]
            ],
            [
                "name" => "iPhone 13",
                "description" => "Apple iPhone 13 - 256GB, Blue",
                "price" => 799.99,
                "quantity" => 20,
                "discount" => 10,
                "discount_expires_at" => "2025-11-01",
                "category_id" => 3,
                "images" => ["images/img1.png", "images/img3.png"]
            ],
            [
                "name" => "Bookshelf",
                "description" => "Large bookshelf with drawers",
                "price" => 199.99,
                "quantity" => 8,
                "discount" => 0,
                "discount_expires_at" => null,
                "category_id" => 2,
                "images" => ["images/img5.png", "images/img4.png"]
            ],
        ];

        foreach ($products as $data) {
            $product = Product::create(Arr::except($data, ['images']));

            foreach ($data['images'] as $path) {
                $product->images()->create([
                    'image_path' => $path
                ]);
            }
        }
    }
}