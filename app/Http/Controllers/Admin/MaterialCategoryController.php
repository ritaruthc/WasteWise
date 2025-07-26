<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaterialCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MaterialCategoryController extends Controller
{
    public function index()
    {
        $categories = MaterialCategory::all();
        return view('admin.material-categories.index', compact('categories'));
    }

    public function showPhoto($id)
    {
        $category = MaterialCategory::findOrFail($id);

        if ($category->photo) {
            return response()->make(base64_decode($category->photo), 200, [
                'Content-Type' => 'image/jpeg',
                'Content-Disposition' => 'inline; filename="' . $category->slug . '.jpg"',
            ]);
        }

        return response()->json(['message' => 'Photo not found.'], 404);
    }



    public function create()
    {
        return view('admin.material-categories.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:material_categories,slug',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|max:2048', // Allow for image upload
        ]);
        $data = $request->all();
        $data['slug'] = Str::slug($request->slug);
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('material-categories', 'public');
        }
        MaterialCategory::create($data);
        return redirect()->route('admin.material-categories.index')->with('success', 'Material category created successfully.');
    }

    public function edit(MaterialCategory $materialCategory){
        return view('admin.material-categories.edit', compact('materialCategory'));
    }

    // public function update(Request $request, MaterialCategory $materialCategory)
    // {
    //     Log::info('Photo file:', [$request->file('photo')]);
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'slug' => 'required|string|max:255|unique:material_categories,slug,' . $materialCategory->id,
    //         'description' => 'nullable|string',
    //         'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Adjust the validation rules as needed
    //     ]);

    //     $data = $request->all();
    //     $data['slug'] = Str::slug($request->slug);

    //     if ($request->hasFile('photo')) {
    //         // Delete old photo
    //         if ($materialCategory->photo) {
    //             Storage::disk('public')->delete($materialCategory->photo);
    //         }
    //         $data['photo'] = $request->file('photo')->store('material-categories', 'public');
    //     }

    //     $materialCategory->update($data);

    //     return redirect()->route('admin.material-categories.index')->with('success', 'Kategori artikel sukses terupdate!');
    // }

    public function update(Request $request, MaterialCategory $materialCategory)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:material_categories,slug,' . $materialCategory->id,
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->slug);

        if ($request->filled('cropped_avatar')) {
            $croppedImage = $request->input('cropped_avatar');
            $image = str_replace('data:image/jpeg;base64,', '', $croppedImage);
            $image = str_replace(' ', '+', $image);
            $imageName = Str::random(10) . '.jpg';
    
            Storage::disk('public')->put('material-categories/' . $imageName, base64_decode($image));
    
            // Delete old photo if exists
            if ($materialCategory->photo) {
                Storage::disk('public')->delete($materialCategory->photo);
            }
    
            $data['photo'] = 'material-categories/' . $imageName;
        }

        $materialCategory->update($data);

        return redirect()->route('admin.material-categories.index')->with('success', 'Kategori artikel sukses terupdate!');
    }





    public function destroy(MaterialCategory $materialCategory)
    {
        // Delete associated photo
        if ($materialCategory->photo) {
            Storage::disk('public')->delete($materialCategory->photo);
        }
        
        $materialCategory->delete();
        return redirect()->route('admin.material-categories.index')->with('success', 'Kategori artikel sukses dihapus.');
    }
}
