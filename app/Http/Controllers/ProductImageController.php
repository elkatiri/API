<?php
namespace App\Http\Controllers;

use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function index()
    {
        return response()->json(ProductImage::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        // Store the image in the storage/app/public/product-images directory
        $imagePath = $request->file('image')->store('product-images', 'public');

        // Create the product image record
        $image = ProductImage::create([
            'product_id' => $validated['product_id'],
            'image_path' => $imagePath
        ]);

        return response()->json($image, 201);
    }

    public function show(ProductImage $productImage)
    {
        return response()->json($productImage);
    }

    public function update(Request $request, ProductImage $productImage)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Delete the old image
        if ($productImage->image_path) {
            Storage::disk('public')->delete($productImage->image_path);
        }

        // Store the new image
        $imagePath = $request->file('image')->store('product-images', 'public');

        // Update the product image record
        $productImage->update([
            'image_path' => $imagePath
        ]);

        return response()->json($productImage);
    }

    public function destroy(ProductImage $productImage)
    {
        // Delete the image file from storage
        if ($productImage->image_path) {
            Storage::disk('public')->delete($productImage->image_path);
        }

        $productImage->delete();
        return response()->json(null, 204);
    }
}
