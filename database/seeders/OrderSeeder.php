<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('order_product')->truncate();
        DB::table('orders')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // IDs des utilisateurs de UserSeeder
        $userIds = [5, 7, 8, 10, 15, 19, 20];
        // IDs de produits existants (adapte selon ta base)
        $productIds = [5, 6, 7, 8, 11, 13, 15, 16];

        $orders = [];
        $orderProducts = [];
        $orderId = 1;

        foreach ($userIds as $userId) {
            // Chaque utilisateur aura 2 commandes
            for ($i = 0; $i < 2; $i++) {
                // Sélectionne 2 produits au hasard
                $products = collect($productIds)->random(2)->all();
                $total = 0;
                $orderProductRows = [];
                foreach ($products as $pid) {
                    $quantity = rand(1, 3);
                    $price = rand(100, 1000); // prix aléatoire pour test
                    $total += $price * $quantity;
                    $orderProductRows[] = [
                        'order_id' => $orderId,
                        'product_id' => $pid,
                        'quantity' => $quantity,
                        'price' => $price,
                    ];
                }
                $orders[] = [
                    'id' => $orderId,
                    'user_id' => $userId,
                    'total_price' => $total,
                    'status' => ['pending', 'completed', 'shipped'][array_rand(['pending', 'completed', 'shipped'])],
                    'shipping_address' => 'Address for user ' . $userId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                $orderProducts = array_merge($orderProducts, $orderProductRows);
                $orderId++;
            }
        }

        DB::table('orders')->insert($orders);
        DB::table('order_product')->insert($orderProducts);
    }
}
