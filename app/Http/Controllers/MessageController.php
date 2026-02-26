<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController
{
    /**
     * Display inbox with list of conversations.
     */
    public function index()
    {
        $userId = Auth::id();

        // Get unique conversations (grouped by product and other user)
        $conversations = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->with(['product', 'sender', 'receiver'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($message) use ($userId) {
                $otherUserId = $message->sender_id === $userId ? $message->receiver_id : $message->sender_id;
                return $message->product_id . '_' . $otherUserId;
            })
            ->map(function ($group) {
                return $group->first();
            });

        return view('messages.index', compact('conversations'));
    }

    /**
     * Show conversation about a product with another user.
     */
    public function show(Product $product, User $user)
    {
        $currentUserId = Auth::id();

        // Get all messages between these two users about this product
        $messages = Message::conversation($currentUserId, $user->id, $product->id)
            ->with(['sender', 'receiver', 'product'])
            ->get();

        // Mark unread messages as read
        Message::where('receiver_id', $currentUserId)
            ->where('sender_id', $user->id)
            ->where('product_id', $product->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('messages.show', compact('messages', 'product', 'user'));
    }

    /**
     * Store a new message.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'message' => 'required|string|max:1000',
        ]);

        $validated['sender_id'] = Auth::id();

        Message::create($validated);

        return redirect()->back()
            ->with('success', 'Pesan berhasil dikirim!');
    }

    /**
     * Show form to send message to seller.
     */
    public function create(Product $product)
    {
        // Cannot message yourself
        if ($product->user_id === Auth::id()) {
            return redirect()->back()
                ->with('error', 'Anda tidak dapat mengirim pesan ke diri sendiri!');
        }

        return view('messages.create', compact('product'));
    }
}
