@extends('layouts.app')

@section('title', 'Pesan - Kampus Marketplace')

@section('content')
<div class="container py-4">
    <!-- Page Header -->
    <div class="mb-4">
        <h2 class="mb-1"><i class="bi bi-chat-dots me-2"></i>Pesan</h2>
        <p class="text-muted mb-0">Kelola percakapan Anda dengan penjual/pembeli</p>
    </div>

    @if($conversations->count() > 0)
        <div class="row g-3">
            @foreach($conversations as $conversation)
                @php
                    $otherUser = $conversation->sender_id === Auth::id() ? $conversation->receiver : $conversation->sender;
                    $unreadCount = \App\Models\Message::where('receiver_id', Auth::id())
                        ->where('sender_id', $otherUser->id)
                        ->where('product_id', $conversation->product_id)
                        ->where('is_read', false)
                        ->count();
                @endphp
                <div class="col-12">
                    <a href="{{ route('messages.show', ['product' => $conversation->product, 'user' => $otherUser]) }}" 
                       class="text-decoration-none">
                        <div class="card hover-shadow">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $conversation->product->foto_url }}" 
                                             alt="{{ $conversation->product->nama_barang }}" 
                                             class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1 text-dark">{{ $otherUser->name }}</h6>
                                                <p class="text-muted small mb-1">{{ $conversation->product->nama_barang }}</p>
                                                <p class="text-dark mb-0 {{ $unreadCount > 0 ? 'fw-bold' : '' }} text-truncate" style="max-width: 500px;">
                                                    @if($conversation->sender_id === Auth::id())
                                                        <i class="bi bi-check2-all text-muted small me-1"></i>
                                                    @endif
                                                    {{ Str::limit($conversation->message, 80) }}
                                                </p>
                                            </div>
                                            <div class="text-end">
                                                <p class="text-muted small mb-1">{{ $conversation->created_at->diffForHumans() }}</p>
                                                @if($unreadCount > 0)
                                                    <span class="badge bg-danger">{{ $unreadCount }} baru</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <i class="bi bi-chat-square-text"></i>
            <h4>Belum Ada Pesan</h4>
            <p class="text-muted">Anda belum memiliki percakapan. Mulai chat dengan penjual produk yang Anda minati!</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary">
                <i class="bi bi-grid me-2"></i>Lihat Produk
            </a>
        </div>
    @endif
</div>

<style>
    .hover-shadow:hover {
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
</style>
@endsection
