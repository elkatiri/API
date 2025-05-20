<?php
namespace App\Http\Controllers;

use App\Models\ColorImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ColorImageController extends Controller
{
    public function index()
    {
        return response()->json(ColorImage::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_color_id' => 'required|exists:product_colors,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        // Store the image in the storage/app/public/color-images directory
        $imagePath = $request->file('image')->store('color-images', 'public');

        // Create the color image record
        $colorImage = ColorImage::create([
            'product_color_id' => $validated['product_color_id'],
            'image_path' => $imagePath
        ]);

        return response()->json($colorImage, 201);
    }

    public function show(ColorImage $colorImage)
    {
        return response()->json($colorImage);
    }

    public function update(Request $request, ColorImage $colorImage)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Delete the old image
        if ($colorImage->image_path) {
            Storage::disk('public')->delete($colorImage->image_path);
        }

        // Store the new image
        $imagePath = $request->file('image')->store('color-images', 'public');

        // Update the color image record
        $colorImage->update([
            'image_path' => $imagePath
        ]);

        return response()->json($colorImage);
    }

    public function destroy(ColorImage $colorImage)
    {
        // Delete the image file from storage
        if ($colorImage->image_path) {
            Storage::disk('public')->delete($colorImage->image_path);
        }

        $colorImage->delete();
        return response()->json(null, 204);
    }
}
