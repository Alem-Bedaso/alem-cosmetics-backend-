<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        // If admin, return all orders with user info
        if ($user->role_id == 2) {
            return Order::with(['items.product', 'user'])->orderBy('created_at', 'desc')->get();
        }
        
        // If customer, return only their orders
        return Order::with('items.product')->where('user_id', $user->id)->get();
    }

    public function show($id)
    {
        return Order::with('items.product')->findOrFail($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'phone' => 'required|string',
        ]);

        $cartItems = Cart::where('user_id', $request->user()->id)->with('product')->get();
        
        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        $order = Order::create([
            'user_id' => $request->user()->id,
            'order_number' => 'ORD-' . time(),
            'total' => $total,
            'shipping_address' => $request->shipping_address,
            'phone' => $request->phone,
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        Cart::where('user_id', $request->user()->id)->delete();

        return response()->json($order->load('items.product'), 201);
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);
        return response()->json($order);
    }
}
