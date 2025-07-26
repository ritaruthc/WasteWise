<?php

namespace App\Http\Controllers;

use App\Models\WasteCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WasteCategoryController extends Controller
{
    public function getCategoryInfo($className)
    {
        Log::info('Received request for class: ' . $className);
        $categoryInfo = WasteCategory::where('class_name', $className)->first();
        Log::info('Query result: ' . json_encode($categoryInfo));
        
        if (!$categoryInfo) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        
        return response()->json($categoryInfo);
    }
}
