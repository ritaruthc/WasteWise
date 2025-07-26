<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\MaterialCategory;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalMaterials = Material::count();
        $totalCategories = MaterialCategory::count();
        $totalUsers = User::count();
        $recentMaterials = Material::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalMaterials', 'totalCategories', 'totalUsers', 'recentMaterials'));
    }
}