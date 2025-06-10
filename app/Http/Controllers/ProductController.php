<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'images', 'colors'])->get();
        return response()->json($products);
    }
    public function getTopDiscountedProducts()
    {
        $products = Product::with(['category', 'images'])
            ->whereNotNull('discount')
            ->where('discount', '>', 0)
            ->orderBy('discount', 'desc')
            ->take(4)
            ->get();

        return response()->json($products);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                 => 'required|string|max:255',
            'description'          => 'nullable|string',
            'price'                => 'required|numeric|min:0',
            'quantity'             => 'required|integer|min:0',
            'discount'             => 'nullable|numeric|min:0|max:100',
            'discount_expires_at'  => 'nullable|date',
            'category_id'          => 'required|exists:categories,id',
            'images.*'             => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'colors'               => 'sometimes|array',
            'colors.*'             => 'required|string|max:50',
        ]);

        $product = Product::create($validated);

        // save colors
        if ($request->filled('colors')) {
            foreach ($request->colors as $color) {
                $product->colors()->create(['color' => $color]);
            }
        }

        // save images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $path = $imageFile->store('product-images', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }

        return response()
            ->json($product->load(['category','images','colors']), 201);
    }

    public function show(Product $product)
    {
        return response()->json(
            $product->load(['category','images','colors'])
        );
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'                 => 'required|string|max:255',
            'description'          => 'nullable|string',
            'price'                => 'required|numeric|min:0',
            'quantity'             => 'required|integer|min:0',
            'discount'             => 'nullable|numeric|min:0|max:100',
            'discount_expires_at'  => 'nullable|date',
            'category_id'          => 'required|exists:categories,id',
            'images.*'             => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images_to_delete'     => 'sometimes|array',
            'images_to_delete.*'   => 'integer|exists:product_images,id',
            'colors'               => 'sometimes|array',
            'colors.*'             => 'required|string|max:50',
        ]);

        // update main fields
        $product->update($validated);

        // sync colors: delete old & re-create
        if ($request->filled('colors')) {
            // remove all existing
            $product->colors()->delete();
            // insert new ones
            foreach ($request->colors as $color) {
                $product->colors()->create(['color' => $color]);
            }
        }

        // delete selected images
        if ($request->filled('images_to_delete')) {
            foreach ($request->images_to_delete as $imageId) {
                $img = $product->images()->find($imageId);
                if ($img) {
                    Storage::disk('public')->delete($img->image_path);
                    $img->delete();
                }
            }
        }

        // add new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $path = $imageFile->store('product-images', 'public');
                $product->images()->create(['image_path' => $path]);
            }
        }

        return response()
            ->json($product->load(['category','images','colors']));
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(null, 204);
    }


}
