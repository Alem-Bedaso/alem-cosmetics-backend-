<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        return Cart::with('product')->where('user_id', $request->user()->id)->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::updateOrCreate(
            ['user_id' => $request->user()->id, 'product_id' => $request->product_id],
            ['quantity' => $request->quantity]
        );

        return response()->json($cart->load('product'), 201);
    }

    public function update(Request $request, $id)
    {
        $cart = Cart::where('user_id', $request->user()->id)->findOrFail($id);
        $cart->update(['quantity' => $request->quantity]);
        return response()->json($cart);
    }

    public function destroy(Request $request, $id)
    {
        Cart::where('user_id', $request->user()->id)->findOrFail($id)->delete();
        return response()->json(['message' => 'Item removed']);
    }
}
