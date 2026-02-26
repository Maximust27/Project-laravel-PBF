<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController 
{
    /**
     * Display the cart.
     */
    public function index()
    {
        $carts = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $total = $carts->sum('subtotal');

        return view('cart.index', compact('carts', 'total'));
    }

    /**
     * Add product to cart.
     */
    public function store(Request $request, Product $product)
    {
        // Check if product belongs to current user
        if ($product->user_id === Auth::id()) {
            return redirect()->back()
                ->with('error', 'Anda tidak dapat membeli produk sendiri!');
        }

        // Check if product already in cart
        $existingCart = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($existingCart) {
            $existingCart->increment('quantity');
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }

        return redirect()->route('cart.index')
            ->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    /**
     * Update cart quantity.
     */
    public function update(Request $request, Cart $cart)
    {
        // Check if cart belongs to current user
        if ($cart->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart->update($validated);

        return redirect()->route('cart.index')
            ->with('success', 'Keranjang berhasil diperbarui!');
    }

    /**
     * Remove item from cart.
     */
    public function destroy(Cart $cart)
    {
        // Check if cart belongs to current user
        if ($cart->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $cart->delete();

        return redirect()->route('cart.index')
            ->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    /**
     * Clear all items from cart.
     */
    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('cart.index')
            ->with('success', 'Keranjang berhasil dikosongkan!');
    }
}
