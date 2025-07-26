<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\MaterialCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Activity;
use Illuminate\Support\Facades\DB;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::with('category')->latest()->paginate(10);
        $categories = MaterialCategory::all();
        
        // Retrieve the last viewed material for the authenticated user
        $recentMaterials = collect();
        if (auth()->check() && auth()->user()->material_id) {
            $recentMaterials = Material::where('id', auth()->user()->material_id)->get();
        }

        return view('materials.index', compact('materials', 'categories', 'recentMaterials'));
    }




    public function show($slug)
    {
        $material = Material::where('slug', $slug)->firstOrFail();

        // Update the user's last viewed material
        if (auth()->check()) {
            DB::table('users')->where('id', auth()->id())->update(['material_id' => $material->id]);
        }

        return view('materials.show', compact('material'));
    }


    public function byCategory($slug)
    {
        $category = MaterialCategory::where('slug', $slug)->firstOrFail();
        $materials = $category->materials()->paginate(10);
        return view('materials.by_category', compact('materials', 'category'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $materials = Material::where('title', 'like', "%$query%")
                             ->orWhere('description', 'like', "%$query%")
                             ->paginate(10);
        return view('materials.search', compact('materials', 'query'));
    }
}