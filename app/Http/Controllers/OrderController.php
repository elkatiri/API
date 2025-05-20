<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'products'])->get();
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
        $order->load(['user', 'products']);
        return response()->json($order);
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'total_price' => 'sometimes|required|numeric|min:0',
            'status' => 'sometimes|string',
            'shipping_address' => 'sometimes|string',
            'products' => 'sometimes|array',
            'products.*.product_id' => 'required_with:products|exists:products,id',
            'products.*.quantity' => 'required_with:products|integer|min:1',
            'products.*.price' => 'required_with:products|numeric|min:0',
        ]);

        $order->update($validated);

        if (isset($validated['products'])) {
            $productsData = [];
            foreach ($validated['products'] as $product) {
                $productsData[$product['product_id']] = [
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                ];
            }
            $order->products()->sync($productsData);
        }

        return response()->json($order->load('products'));
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(null, 204);
    }
}
