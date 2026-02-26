<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'product_id',
        'message',
        'is_read',
    ];

    /**
     * Get the sender that owns the message.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Get the receiver that owns the message.
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /**
     * Get the product that belongs to the message.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get formatted created at attribute.
     */
    public function getFormattedCreatedAtAttribute(): string
    {
        return $this->created_at->format('d M Y H:i');
    }

    /**
     * Scope for unread messages.
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope for messages between two users about a product.
     */
    public function scopeConversation($query, $user1, $user2, $productId)
    {
        return $query->where(function ($q) use ($user1, $user2) {
            $q->where(function ($sq) use ($user1, $user2) {
                $sq->where('sender_id', $user1)->where('receiver_id', $user2);
            })->orWhere(function ($sq) use ($user1, $user2) {
                $sq->where('sender_id', $user2)->where('receiver_id', $user1);
            });
        })->where('product_id', $productId)
          ->orderBy('created_at', 'asc');
    }
}
