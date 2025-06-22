<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadController extends Controller
{
    /**
     * Upload image for TinyMCE editor
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120', // Max 5MB
        ]);

        try {
            if ($request->hasFile('file')) {
                $file = $request->file('file');

                // Generate unique filename
                $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

                // Store in public/storage/images/lessons
                $path = $file->storeAs('images/lessons', $filename, 'public');

                // Return the URL for TinyMCE
                return response()->json([
                    'location' => Storage::url($path)
                ]);
            }

            return response()->json(['error' => 'No file uploaded'], 400);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Upload failed: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Delete uploaded image
     */
    public function delete(Request $request)
    {
        $request->validate([
            'path' => 'required|string'
        ]);

        try {
            // Extract the path from the full URL
            $path = str_replace('/storage/', '', $request->path);

            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
                return response()->json(['success' => true]);
            }

            return response()->json(['error' => 'File not found'], 404);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Delete failed: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Browse uploaded images for TinyMCE file manager
     */
    public function browse()
    {
        try {
            $files = Storage::disk('public')->files('images/lessons');
            $images = [];

            foreach ($files as $file) {
                if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp'])) {
                    $images[] = [
                        'title' => basename($file),
                        'value' => Storage::url($file),
                        'meta' => [
                            'alt' => basename($file, '.' . pathinfo($file, PATHINFO_EXTENSION)),
                            'dimensions' => $this->getImageDimensions(Storage::disk('public')->path($file))
                        ]
                    ];
                }
            }

            return response()->json($images);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Browse failed: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Get image dimensions
     */
    private function getImageDimensions($path)
    {
        if (file_exists($path)) {
            $size = getimagesize($path);
            return $size ? ['width' => $size[0], 'height' => $size[1]] : null;
        }
        return null;
    }
}
