<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::latest()
            ->withCount(['products', 'active_products'])
            ->get();
        return CategoryResource::collection($categories);
    }
    public function active(){
        return Category::latest()->where('is_active', true)->with(['active_products'])->get();
    }
    public function store(Request $request){
        $request->validate([
            'name' => ['required', 'max:255']
        ]);
        $category = Category::create([
            'name' => $request->name,
            'slug' => str_replace(' ', '-', strtolower($request->name))
        ]);
        return response()->json([
            'message' => 'Category has been added!',
            'category' => $category
        ], 201);
    }
    public function status(Category $category){
        $category->is_active = !$category->is_active;
        $category->save();
        return response()->json([
            'message' => 'Category has been updated!'
        ], 201);
    }
}