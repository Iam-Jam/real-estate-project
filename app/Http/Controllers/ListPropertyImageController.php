<?php

namespace App\Http\Controllers;

use App\Models\ListProperty;
use App\Models\ListPropertyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ListPropertyImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store new images for a property
     */
    public function store(Request $request, ListProperty $property)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'images' => 'array|max:3'
        ]);

        try {
            if ($request->hasFile('images')) {
                $currentImageCount = $property->images()->count();
                $newImagesCount = count($request->file('images'));

                if (($currentImageCount + $newImagesCount) > 3) {
                    return back()->with('error', 'Maximum of 3 images allowed. You can upload ' . (3 - $currentImageCount) . ' more images.');
                }

                foreach ($request->file('images') as $image) {
                    // Generate unique filename
                    $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                    // Save to uploads/uploads directory
                    $path = 'uploads/uploads/' . $filename;
                    $image->move(public_path('uploads/uploads'), $filename);

                    $property->images()->create([
                        'image_path' => $path,
                        'is_primary' => $property->images()->count() === 0
                    ]);
                }

                return back()->with('success', 'Images uploaded successfully.');
            }

            return back()->with('error', 'No images were provided.');

        } catch (\Exception $e) {
            \Log::error('Image upload error: ' . $e->getMessage());
            return back()->with('error', 'Failed to upload images. Please try again.');
        }
    }

    /**
     * Delete an image
     */
    public function destroy(ListPropertyImage $image)
    {
        try {
            // Check if user has permission
            if (auth()->id() !== $image->property->user_id && !auth()->user()->isAdmin()) {
                return back()->with('error', 'Unauthorized action.');
            }

            // If deleting primary image, set another image as primary
            if ($image->is_primary) {
                $nextImage = $image->property->images()
                    ->where('id', '!=', $image->id)
                    ->first();

                if ($nextImage) {
                    $nextImage->update(['is_primary' => true]);
                }
            }

            // Delete the image file
            Storage::disk('public')->delete($image->image_path);

            // Delete the database record
            $image->delete();

            return back()->with('success', 'Image deleted successfully.');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete image. Please try again.');
        }
    }

    /**
     * Set an image as primary
     */
    public function setPrimary(ListPropertyImage $image)
    {
        try {
            // Check if user has permission
            if (auth()->id() !== $image->property->user_id && !auth()->user()->isAdmin()) {
                return back()->with('error', 'Unauthorized action.');
            }

            // Remove primary status from all other images
            $image->property->images()
                ->where('id', '!=', $image->id)
                ->update(['is_primary' => false]);

            // Set this image as primary
            $image->update(['is_primary' => true]);

            return back()->with('success', 'Primary image updated successfully.');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update primary image. Please try again.');
        }
    }

    /**
     * Reorder images
     */
    public function reorder(Request $request, ListProperty $property)
    {
        $request->validate([
            'image_order' => 'required|array',
            'image_order.*' => 'exists:list_sell_property_images,id'
        ]);

        try {
            foreach ($request->image_order as $index => $imageId) {
                ListPropertyImage::where('id', $imageId)
                    ->update(['display_order' => $index]);
            }

            return response()->json(['message' => 'Images reordered successfully']);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to reorder images'], 500);
        }
    }
}
