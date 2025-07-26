<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\MaterialCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::with('category')->latest()->paginate(10);
        return view('admin.materials.index', compact('materials'));
    }

    public function create()
    {
        $categories = MaterialCategory::all();
        return view('admin.materials.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'content' => 'required',
            'category_id' => 'required|exists:material_categories,id',
        ]);

        Material::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'content' => $request->content,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('admin.materials.index')->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function edit(Material $material)
    {
        $categories = MaterialCategory::all();
        return view('admin.materials.edit', compact('material', 'categories'));
    }

    public function update(Request $request, Material $material)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'content' => 'required',
            'category_id' => 'required|exists:material_categories,id',
        ]);

        $material->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'content' => $request->content,
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('admin.materials.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Material $material)
    {
        $material->delete();
        return redirect()->route('admin.materials.index')->with('success', 'Artikel berhasil dihapus.');
    }
}