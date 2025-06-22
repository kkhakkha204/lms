<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LessonMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    public function destroy(LessonMaterial $material)
    {
        try {
            // Xóa file từ storage
            if (Storage::disk('public')->exists($material->file_path)) {
                Storage::disk('public')->delete($material->file_path);
            }

            // Xóa record từ database
            $material->delete();

            return response()->json([
                'success' => true,
                'message' => 'Tài liệu đã được xóa thành công'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa tài liệu'
            ], 500);
        }
    }
    /**
     * Download a lesson material
     */
    public function download(LessonMaterial $material)
    {
        try {
            if (Storage::disk('public')->exists($material->file_path)) {
                return Storage::disk('public')->download($material->file_path, $material->file_name);
            }

            abort(404, 'File not found');

        } catch (\Exception $e) {
            abort(500, 'Download failed: ' . $e->getMessage());
        }
    }
}
