<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('status', 'completed')->sum('total_amount'),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function users()
    {
        $users = User::with('role')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
    }

    public function destroyUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
    }

    public function products()
    {
        $products = Product::with(['user', 'category'])->paginate(10);
        $categories = \App\Models\Category::all();
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:active,inactive',
            'image' => 'required|image|max:2048',
        ]);

        $path = $request->file('image')->store('products', 'public');
        $validated['image'] = $path;
        $validated['user_id'] = auth()->id();

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    public function updateProduct(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
            }
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function destroyProduct(Product $product)
    {
        if ($product->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }

    public function orders()
    {
        $orders = Order::with(['user', 'items.product'])->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function updateOrder(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order status updated successfully.');
    }

    public function sales()
    {
        $salesData = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total_orders'),
            DB::raw('SUM(total_amount) as total_revenue')
        )
        ->where('status', 'completed')
        ->groupBy('date')
        ->orderBy('date', 'desc')
        ->take(30)
        ->get();

        return view('admin.sales.index', compact('salesData'));
    }
} 