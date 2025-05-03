<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('supplier');
    }

    public function index()
    {
        $supplier = Auth::user();
        
        // Get statistics
        $stats = [
            'total_products' => Product::where('supplier_id', $supplier->id)->count(),
            'total_orders' => Order::whereHas('items.product', function($query) use ($supplier) {
                $query->where('supplier_id', $supplier->id);
            })->count(),
            'total_revenue' => Order::whereHas('items.product', function($query) use ($supplier) {
                $query->where('supplier_id', $supplier->id);
            })->where('status', 'completed')->sum('total_amount'),
        ];

        // Get recent orders
        $recentOrders = Order::whereHas('items.product', function($query) use ($supplier) {
            $query->where('supplier_id', $supplier->id);
        })
        ->with('user')
        ->latest()
        ->take(5)
        ->get();

        return view('supplier.dashboard', compact('stats', 'recentOrders'));
    }

    public function products()
    {
        $products = Product::where('supplier_id', Auth::id())
            ->with('category')
            ->latest()
            ->paginate(10);

        return view('supplier.products.index', compact('products'));
    }

    public function createProduct()
    {
        $categories = \App\Models\Category::all();
        return view('supplier.products.create', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = new Product($validated);
        $product->supplier_id = Auth::id();
        $product->status = 'active';

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
        }

        $product->save();

        return redirect()->route('supplier.products')
            ->with('success', 'Product created successfully.');
    }

    public function editProduct(Product $product)
    {
        if ($product->supplier_id !== Auth::id()) {
            abort(403);
        }

        $categories = \App\Models\Category::all();
        return view('supplier.products.edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        if ($product->supplier_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        $product->update($validated);

        return redirect()->route('supplier.products')
            ->with('success', 'Product updated successfully.');
    }

    public function destroyProduct(Product $product)
    {
        if ($product->supplier_id !== Auth::id()) {
            abort(403);
        }

        $product->delete();

        return redirect()->route('supplier.products')
            ->with('success', 'Product deleted successfully.');
    }

    public function orders()
    {
        $orders = Order::whereHas('items.product', function($query) {
            $query->where('supplier_id', Auth::id());
        })
        ->with(['user', 'items.product'])
        ->latest()
        ->paginate(10);

        return view('supplier.orders.index', compact('orders'));
    }

    public function showOrder(Order $order)
    {
        if (!$order->items()->whereHas('product', function($query) {
            $query->where('supplier_id', Auth::id());
        })->exists()) {
            abort(403);
        }

        $order->load(['user', 'items.product']);
        return view('supplier.orders.show', compact('order'));
    }
} 