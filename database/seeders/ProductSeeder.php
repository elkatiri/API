<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
                'name' => 'iPhone 13',
                'description' => 'Apple iPhone 13 - 256GB, Blue',
                'price' => 793.99,
                'quantity' => 20,
                'discount' => 15.00,
                'discount_expires_at' => null,
                'category_id' => 2,
            ],
            [
                'name' => 'Bookshelf',
                'description' => 'Large bookshelf with drawers',
                'price' => 199.99,
                'quantity' => 8,
                'discount' => 0.00,
                'discount_expires_at' => null,
                'category_id' => 2,
            ],
            [
                'name' => 'Sofa',
                'description' => 'Comfortable sofa',
                'price' => 299.99,
                'quantity' => 10,
                'discount' => 10.00,
                'discount_expires_at' => null,
                'category_id' => 4,
            ],
            [
                'name' => 'Office Chair',
                'description' => 'Ergonomic office chair',
                'price' => 151.99,
                'quantity' => 15,
                'discount' => 5.00,
                'discount_expires_at' => null,
                'category_id' => 2,
            ],
            [
                'name' => 'PC Gamer',
                'description' => 'High-end gaming PC',
                'price' => 30000.00,
                'quantity' => 5,
                'discount' => 20.00,
                'discount_expires_at' => null,
                'category_id' => 3,
            ],
            [
                'name' => 'iPhone 14 Pro Max',
                'description' => 'Latest iPhone model',
                'price' => 600.00,
                'quantity' => 12,
                'discount' => 15.00,
                'discount_expires_at' => null,
                'category_id' => 3,
            ],
            [
                'name' => 'Bookshelf Deluxe',
                'description' => 'Premium bookshelf with glass doors',
                'price' => 299.99,
                'quantity' => 7,
                'discount' => 10.00,
                'discount_expires_at' => null,
                'category_id' => 2,
            ],
            [
                'name' => 'Smart TV',
                'description' => '4K Ultra HD Smart TV',
                'price' => 1200.00,
                'quantity' => 6,
                'discount' => 25.00,
                'discount_expires_at' => null,
                'category_id' => 4,
            ],
        ];

        // Create products using Eloquent for better relationship handling
        $createdProducts = [];
        foreach ($products as $productData) {
            $product = Product::create($productData);
            $createdProducts[$product->name] = $product;
        }

        // Handle images from storage if they exist
        if (Storage::disk('public')->exists('product-images')) {
            $storageImages = Storage::disk('public')->files('product-images');
            
            if (!empty($storageImages)) {
                $productNames = array_keys($createdProducts);
                $productCount = count($productNames);
                $i = 0;
                
                foreach ($storageImages as $imgPath) {
                    $productName = $productNames[$i % $productCount];
                    $product = $createdProducts[$productName];
                    
                    // Use Eloquent relationship for consistency
                    $product->images()->create([
                        'image_path' => $imgPath
                    ]);
                    
                    $i++;
                }
            }
        } else {
            // Fallback to predefined images if storage directory doesn't exist
            $fallbackImages = [
                'iPhone 13' => ['images/iphone13.jpg', 'images/iphone13_blue.jpg'],
                'Bookshelf' => ['images/bookshelf.jpg'],
                'Sofa' => ['images/sofa.jpg', 'images/sofa_side.jpg'],
                'Office Chair' => ['images/chair.jpg'],
                'PC Gamer' => ['images/pc_gamer.jpg', 'images/pc_gamer_rgb.jpg'],
                'iPhone 14 Pro Max' => ['images/iphone14.jpg'],
                'Bookshelf Deluxe' => ['images/bookshelf_deluxe.jpg'],
                'Smart TV' => ['images/smart_tv.jpg'],
            ];
            
            foreach ($fallbackImages as $productName => $imagePaths) {
                if (isset($createdProducts[$productName])) {
                    $product = $createdProducts[$productName];
                    foreach ($imagePaths as $imagePath) {
                        $product->images()->create([
                            'image_path' => $imagePath
                        ]);
                    }
                }
            }
        }
    }
}