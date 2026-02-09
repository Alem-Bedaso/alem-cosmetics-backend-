<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        return Product::with(['category', 'supplier', 'reviews'])->where('is_active', true)->paginate(20);
    }

    public function show($id)
    {
        return Product::with(['category', 'supplier', 'reviews.user'])->findOrFail($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'images' => 'nullable|array',
        ]);

        $product = Product::create([
            'category_id' => $request->category_id,
            'supplier_id' => $request->user()->id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'images' => $request->images,
        ]);

        return response()->json($product, 201);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $request->validate([
            'name' => 'string',
            'description' => 'string',
            'price' => 'numeric',
            'stock' => 'integer',
        ]);

        $product->update($request->all());
        return response()->json($product);
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return response()->json(['message' => 'Product deleted']);
    }
}
