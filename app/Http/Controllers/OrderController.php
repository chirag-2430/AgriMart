<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            $orders = Order::with(['user', 'items.product'])->latest()->get();
        } else {
            $orders = $user->orders()->with(['items.product'])->latest()->get();
        }
        
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        return view('orders.show', compact('order'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Order::class);
        
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }
        
        $totalAmount = 0;
        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }
        
        DB::beginTransaction();
        
        try {
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_amount' => $totalAmount,
                'status' => 'pending',
            ]);
            
            foreach ($cart as $item) {
                $product = Product::findOrFail($item['id']);
                
                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Not enough stock for {$product->name}");
                }
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ]);
                
                $product->update([
                    'stock' => $product->stock - $item['quantity']
                ]);
            }
            
            DB::commit();
            
            session()->forget('cart');
            
            return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', $e->getMessage());
        }
    }

    public function updateStatus(Request $request, Order $order)
    {
        $this->authorize('update', $order);
        
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);
        
        $order->update([
            'status' => $request->status,
        ]);
        
        return redirect()->route('orders.show', $order)->with('success', 'Order status updated!');
    }
}
