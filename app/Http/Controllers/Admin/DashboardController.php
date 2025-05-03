<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index()
    {
        $totalFarmers = User::whereHas('role', function($query) {
            $query->where('name', 'Farmer');
        })->count();
        
        $totalSuppliers = User::whereHas('role', function($query) {
            $query->where('name', 'Supplier');
        })->count();
        
        $totalProducts = Product::count();
        
        $totalOrders = Order::count();
        $totalSales = Order::where('status', 'completed')->sum('total_amount');
        
        $recentOrders = Order::with(['user', 'items.product'])
            ->latest()
            ->take(5)
            ->get();
        
        return view('admin.dashboard', compact(
            'totalFarmers',
            'totalSuppliers',
            'totalProducts',
            'totalOrders',
            'totalSales',
            'recentOrders'
        ));
    }

    public function users()
    {
        $users = User::with('role')->get();
        return view('admin.users', compact('users'));
    }

    public function products()
    {
        $products = Product::with(['category', 'supplier'])->get();
        return view('admin.products', compact('products'));
    }

    public function orders()
    {
        $orders = Order::with(['user', 'items.product'])->latest()->get();
        return view('admin.orders', compact('orders'));
    }

    public function sales()
    {
        $completedOrders = Order::where('status', 'completed')->get();
        $totalSales = $completedOrders->sum('total_amount');
        
        $categorySales = [];
        foreach ($completedOrders as $order) {
            foreach ($order->items as $item) {
                $category = $item->product->category->name;
                if (!isset($categorySales[$category])) {
                    $categorySales[$category] = 0;
                }
                $categorySales[$category] += $item->price * $item->quantity;
            }
        }
        
        return view('admin.sales', compact('completedOrders', 'totalSales', 'categorySales'));
    }
}
