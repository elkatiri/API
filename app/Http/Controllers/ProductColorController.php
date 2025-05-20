<?php
namespace App\Http\Controllers;

use App\Models\ProductColor;
use Illuminate\Http\Request;

class ProductColorController extends Controller
{
    public function index()
    {
        return response()->json(ProductColor::with('colorImages')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'color' => 'required|string|max:50',
        ]);

        $color = ProductColor::create($validated);
        return response()->json($color, 201);
    }

    public function show(ProductColor $productColor)
    {
        $productColor->load('colorImages');
        return response()->json($productColor);
    }

    public function update(Request $request, ProductColor $productColor)
    {
        $validated = $request->validate([
            'color' => 'required|string|max:50',
        ]);

        $productColor->update($validated);
        return response()->json($productColor);
    }

    public function destroy(ProductColor $productColor)
    {
        $productColor->delete();
        return response()->json(null, 204);
    }
}
