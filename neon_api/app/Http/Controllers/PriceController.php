<?php

namespace App\Http\Controllers;

use App\Models\Price;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\PriceResource;
use App\Http\Resources\ProductResource;

class PriceController extends Controller
{
    public function index(){
        return [
            'prices' => PriceResource::collection(Price::latest()->with(['product'])->get()),
            'products' => ProductResource::collection(Product::latest()->get())
        ];
    }

    public function store(Request $request){
        $request->validate([
            'name' => ['required', 'max:255'],
            'price' => ['required', 'numeric'],
            'product' => ['required']
        ]);
        $product = Product::where('slug', $request->product)->first();
        if(!$product){
            return response()->json([
                'message' => 'Product not found!'
            ], 404);
        }
        Price::create([
            'name' => $request->name,
            'price' => $request->price,
            'product_id' => $product->id
        ]);
        return response()->json([
            'message' => 'Price has been added!'
        ], 201);
    }
}