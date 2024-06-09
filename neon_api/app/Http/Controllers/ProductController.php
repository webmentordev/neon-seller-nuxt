<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Stripe\StripeClient;

class ProductController extends Controller
{
    public function index(){
        $products = Product::latest()->with(['category', 'prices'])->get();
        return ProductResource::collection($products);
    }

    public function active(){
        $products = Product::latest()->where('is_active', true)->with(['prices'])->get();
        return ProductResource::collection($products);
    }

    public function store(Request $request){
        $request->validate([
            'title' => ['required', 'max:255'],
            'name' => ['required', 'max:255'],
            'slug' => ['required'],
            'description' => ['required'],
            'seo' => ['required'],
            'body' => ['required'],
            'image' => ['required', 'max:1024', 'image', 'mimes:jpg,png,webp'],
            'category' => ['required', 'max:255']
        ]);
        $stripe = new StripeClient(config('app.stripe'));  
        $result = $stripe->products->create(['name' => $request->title]);
        $category = Category::where('slug', $request->category)->first();
        $slug = str_replace(' ', '-', strtolower($request->slug)).'-'.rand(9, 99999999);
        Product::create([
            'title' => $request->title,
            'stripe_id' => $result['id'],
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'seo' => $request->seo,
            'body' => $request->body,
            'image' => $request->image->storeAs('products', $slug.'image'.'.'.$request->image->getClientOriginalExtension()),
            'category_id' => $category->id
        ]);
        return response()->json([
            'message' => 'Product has been added!'
        ], 201);
    }

    public function show(Product $product){
        if(!$product){ 
            return response()->json([
                'message' => 'Product not found!'
            ], 404);
        }
        return new ProductResource($product);
    }
}