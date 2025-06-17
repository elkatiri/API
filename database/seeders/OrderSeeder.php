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

        $userIds    = DB::table('users')->pluck('id')->toArray();
        $productIds = DB::table('products')->pluck('id')->toArray();

        if (count($userIds) === 0 || count($productIds) < 2) {
            return; // pas assez de données
        }

        $orders        = [];
        $orderProducts = [];

        // choisir 6 mois distincts parmi les 12
        $months = collect(range(1, 12))->shuffle()->take(6)->values()->all();

        foreach ($months as $index => $month) {
            $orderId  = $index + 1;
            $userId   = collect($userIds)->random();
            $products = collect($productIds)->random(2)->all();
            $total    = 0;
            $rows     = [];

            foreach ($products as $pid) {
                $quantity = rand(1, 3);
                $price    = rand(100, 1000);
                $total   += $price * $quantity;

                $rows[] = [
                    'order_id'   => $orderId,
                    'product_id' => $pid,
                    'quantity'   => $quantity,
                    'price'      => $price,
                ];
            }

            // jour aléatoire 1–28 pour éviter fin de mois
            $day       = rand(1, 28);
            $createdAt = Carbon::create(
                Carbon::now()->year,
                $month,
                $day,
                rand(0, 23),
                rand(0, 59),
                rand(0, 59)
            );
            $updatedAt = (clone $createdAt)->addDays(rand(0, 5));

            $orders[] = [
                'id'               => $orderId,
                'user_id'          => $userId,
                'total_price'      => $total,
                'status'           => ['pending', 'completed', 'shipped'][rand(0, 2)],
                'shipping_address' => 'Testing address for user ' . $userId,
                'created_at'       => $createdAt,
                'updated_at'       => $updatedAt,
            ];

            $orderProducts = array_merge($orderProducts, $rows);
        }

        DB::table('orders')->insert($orders);
        DB::table('order_product')->insert($orderProducts);
    }
}
