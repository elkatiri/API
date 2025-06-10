<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with([
            'user',
            'products.images',
            'products.category' // <-- add this line
        ])->get();

        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'total_price' => 'required|numeric|min:0',
            'status' => 'nullable|string',
            'shipping_address' => 'nullable|string',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
        ]);

        $order = Order::create($validated);

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
                'products.category' // <-- add this line
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

    // ADD THIS METHOD FOR STATUS UPDATE
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