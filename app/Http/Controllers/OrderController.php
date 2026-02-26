<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController 
{
    /**
     * Display a listing of the user's orders.
     */
    public function index()
    {
        $orders = Order::with('orderItems.product')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Show checkout page.
     */
    public function checkout()
    {
        $carts = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang Anda kosong!');
        }

        $total = $carts->sum('subtotal');

        return view('orders.checkout', compact('carts', 'total'));
    }

    /**
     * Process checkout and create order.
     */
    public function store(Request $request)
    {
        $carts = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang Anda kosong!');
        }

        try {
            DB::beginTransaction();

            // Calculate total
            $total = $carts->sum('subtotal');

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_harga' => $total,
                'status' => 'pending',
            ]);

            // Create order items
            foreach ($carts as $cart) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->quantity,
                    'harga' => $cart->product->harga,
                ]);
            }

            // Clear cart
            Cart::where('user_id', Auth::id())->delete();

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', 'Pesanan berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')
                ->with('error', 'Terjadi kesalahan saat membuat pesanan. Silakan coba lagi.');
        }
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        // Check if user owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $order->load('orderItems.product');

        return view('orders.show', compact('order'));
    }

    /**
     * Mark order as completed.
     */
    public function complete(Order $order)
    {
        // Check if user owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Only pending orders can be completed
        if ($order->status !== 'pending') {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Pesanan sudah selesai!');
        }

        $order->update(['status' => 'selesai']);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Pesanan berhasil diselesaikan!');
    }
}
