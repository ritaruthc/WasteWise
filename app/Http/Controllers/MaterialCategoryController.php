<?php

namespace App\Http\Controllers;

use App\Models\MaterialCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

// class MaterialCategoryController extends Controller
// {
//     // Menampilkan daftar kategori material
//     public function index()
//     {
//         $categories = MaterialCategory::all();
//         return view('material_categories.index', compact('categories'));
//     }

//     // Menampilkan form untuk membuat kategori material baru
//     public function create()
//     {
//         return view('material_categories.create');
//     }

//     // Menyimpan kategori material baru
//     public function store(Request $request)
//     {
//         $request->validate([
//             'name' => 'required|max:255',
//             'slug' => 'required|max:255|unique:material_categories,slug',
//             'description' => 'nullable',
//             'photo' => 'nullable',
//         ]);
        

//         MaterialCategory::create($request->all());

//         return redirect()->route('material_categories.index')
//                         ->with('success', 'Material category created successfully.');
//     }



//     // Menampilkan detail kategori material tertentu
//     public function show(MaterialCategory $materialCategory)
//     {
//         return view('material_categories.show', compact('materialCategory'));
//     }

//     // Menampilkan form untuk mengedit kategori material
//     public function edit(MaterialCategory $materialCategory)
//     {
//         return view('material_categories.edit', compact('materialCategory'));
//     }

    
//     // Mengupdate kategori material
//     public function update(Request $request, $id)
//     {
//         Log::info('Photo file:', [$request->file('photo')]);
//         $request->validate([
//             'name' => 'required|string|max:255',
//             'slug' => 'required|string|max:255',
//             'description' => 'nullable|string',
//             'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Adjust the validation rules as needed
//         ]);

//         $materialCategory = MaterialCategory::findOrFail($id);


//         if ($request->hasFile('photo')) {
//             $image = $request->file('photo');
//             $imageData = file_get_contents($image->getRealPath());

//             // Log to confirm binary data was read
//             Log::info('Binary data:', [$imageData]);

//             $materialCategory->photo = $imageData;
//         }

//         $materialCategory->name = $request->name;
//         $materialCategory->slug = $request->slug;
//         $materialCategory->description = $request->description;

//         $materialCategory->save();

//         return redirect()->route('admin.material-categories.index')->with('success', 'Material Category updated successfully.');
//     }


//     // Menghapus kategori material
//     public function destroy(MaterialCategory $materialCategory)
//     {
//         $materialCategory->delete();

//         return redirect()->route('material_categories.index')
//                          ->with('success', 'Material category deleted successfully.');
//     }
// }

