<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'supplier'])->get();
        return view('products.index', compact('products'));
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function create()
    {
        $this->authorize('create', Product::class);
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Product::class);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',

            'image' => 'nullable|image|max:2048',
        ]);

        $validated['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        Product::create($validated);

        return redirect()->route('supplier.products')->with('success', 'Product added successfully!');
    }

    public function edit(Product $product)
    {
        $this->authorize('update', $product);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        $product->update($validated);

        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.products')->with('success', 'Product updated successfully!');
        } else {
            return redirect()->route('supplier.products')->with('success', 'Product updated successfully!');
        }
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();
        
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.products')->with('success', 'Product deleted successfully!');
        } else {
            return redirect()->route('supplier.products')->with('success', 'Product deleted successfully!');
        }
    }
}
