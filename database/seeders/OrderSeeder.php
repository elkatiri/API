<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('order_product')->truncate();
        DB::table('orders')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Récupère tous les IDs utilisateurs et produits existants
        $userIds = DB::table('users')->pluck('id')->toArray();
        $productIds = DB::table('products')->pluck('id')->toArray();

        $orders = [];
        $orderProducts = [];
        $orderId = 1;

        // Pour chaque mois de l'année
        for ($month = 1; $month <= 12; $month++) {
            foreach ($userIds as $userId) {
                // Sélectionne 2 produits différents à chaque commande
                $products = collect($productIds)->random(2)->all();
                $total = 0;
                $orderProductRows = [];
                foreach ($products as $pid) {
                    $quantity = rand(1, 3);
                    $price = rand(100, 1000);
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
                    'created_at' => Carbon::create(2025, $month, rand(1, 28), rand(8, 18), rand(0, 59), 0),
                    'updated_at' => Carbon::create(2025, $month, rand(1, 28), rand(8, 18), rand(0, 59), 0),
                ];
                $orderProducts = array_merge($orderProducts, $orderProductRows);
                $orderId++;
            }
        }

        DB::table('orders')->insert($orders);
        DB::table('order_product')->insert($orderProducts);
    }
}
