<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('farmer');
    }

    public function index()
    {
        $categories = Category::all();
        $featuredProducts = Product::where('stock', '>', 0)
            ->with(['category', 'supplier'])
            ->latest()
            ->take(4)
            ->get();
        
        $totalOrders = auth()->user()->orders()->count();
        
        return view('farmer.dashboard', compact(
            'categories',
            'featuredProducts',
            'totalOrders'
        ));
    }

    public function browse(Request $request)
    {
        $query = Product::where('stock', '>', 0)->with(['category', 'supplier']);
        
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $products = $query->paginate(12);
        $categories = Category::all();
        
        return view('farmer.browse', compact('products', 'categories'));
    }
}
