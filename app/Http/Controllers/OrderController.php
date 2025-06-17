<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with([
            'user',
            'products.images',
            'products.category'
        ])->get();

        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'total_price' => 'required|numeric|min:0',
            'status' => 'nullable|string',
            'shipping_address' => 'nullable|string',
            'customer_info' => 'nullable|array',
            'customer_info.firstName' => 'required_with:customer_info|string',
            'customer_info.lastName' => 'required_with:customer_info|string',
            'customer_info.name' => 'required_with:customer_info|string',
            'customer_info.email' => 'required_with:customer_info|email',
            'customer_info.phone' => 'required_with:customer_info|string',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        $userId = $validated['user_id'];

        // Si pas d'user_id et qu'on a des customer_info, créer un utilisateur invité
        if (!$userId && isset($validated['customer_info'])) {
            $customerInfo = $validated['customer_info'];
            
            // Vérifier si un utilisateur avec cet email existe déjà
            $existingUser = User::where('email', $customerInfo['email'])->first();
            
            if ($existingUser) {
                $userId = $existingUser->id;
            } else {
                // Créer un nouvel utilisateur invité
                $user = User::create([
                    'name' => $customerInfo['name'],
                    'email' => $customerInfo['email'],
                    'phone' => $customerInfo['phone'] ?? null,
                    'password' => Hash::make(Str::random(12)), // Mot de passe aléatoire
                    'is_guest' => true, // Marquer comme utilisateur invité
                    'email_verified_at' => null, // Pas vérifié par défaut
                ]);
                $userId = $user->id;
            }
        }

        // Si toujours pas d'userId, erreur
        if (!$userId) {
            return response()->json([
                'message' => 'User ID is required or customer information must be provided'
            ], 400);
        }

        $orderData = [
            'user_id' => $userId,
            'total_price' => $validated['total_price'],
            'status' => $validated['status'] ?? 'pending',
            'shipping_address' => $validated['shipping_address'],
        ];

        $order = Order::create($orderData);

        // Attach products with pivot data
        $productsData = [];
        foreach ($validated['products'] as $product) {
            $productsData[$product['product_id']] = [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
            ];
        }
        $order->products()->attach($productsData);

        return response()->json($order->load('products'), 201);
    }

    public function show(Order $order)
    {
        return response()->json(
            $order->load([
                'user',
                'products.images',
                'products.category'
            ])
        );
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'user_id'           => 'sometimes|exists:users,id',
            'total_price'       => 'sometimes|numeric|min:0',
            'status'            => 'sometimes|string',
            'shipping_address'  => 'sometimes|string',
            'products'                  => 'sometimes|array',
            'products.*.product_id'     => 'required_with:products|exists:products,id',
            'products.*.quantity'       => 'required_with:products|integer|min:1',
            'products.*.price'          => 'required_with:products|numeric|min:0',
        ]);

        // Update order fields
        $order->update($validated);

        // Update products if provided
        if (isset($validated['products'])) {
            $productsData = [];
            foreach ($validated['products'] as $product) {
                $productsData[$product['product_id']] = [
                    'quantity' => $product['quantity'],
                    'price'    => $product['price'],
                ];
            }
            $order->products()->sync($productsData);

            // Calculate total_price
            $total = 0;
            foreach ($order->products as $product) {
                $total += $product->pivot->price * $product->pivot->quantity;
            }
            $order->total_price = $total;
            $order->save();
        }

        return response()->json($order->load(['user', 'products.images']));
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(null, 204);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|string',
        ]);
        $order->status = $validated['status'];
        $order->save();

        return response()->json([
            'message' => 'Status updated',
            'order' => $order->load(['user', 'products.images'])
        ]);
    }
}