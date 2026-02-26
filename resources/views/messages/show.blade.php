@extends('layouts.app')

@section('title', 'Chat - ' . $product->nama_barang . ' - Kampus Marketplace')

@section('content')
<div class="container py-4">
    <!-- Chat Header -->
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <a href="{{ route('messages.index') }}" class="btn btn-outline-secondary btn-sm me-3">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <div class="flex-shrink-0">
                    <img src="{{ $product->foto_url }}" alt="{{ $product->nama_barang }}" 
                         class="rounded" style="width: 50px; height: 50px; object-fit: cover;">
                </div>
                <div class="flex-grow-1 ms-3">
                    <h5 class="mb-0">{{ $user->name }}</h5>
                    <p class="text-muted small mb-0">{{ $product->nama_barang }}</p>
                </div>
                <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-eye me-1"></i>Lihat Produk
                </a>
            </div>
        </div>
    </div>

    <!-- Chat Messages -->
    <div class="card">
        <div class="card-body" style="min-height: 400px; max-height: 500px; overflow-y: auto;" id="chat-container">
            @if($messages->count() > 0)
                @foreach($messages as $message)
                    <div class="chat-bubble {{ $message->sender_id === Auth::id() ? 'sent' : 'received' }}">
                        <p class="mb-1">{{ $message->message }}</p>
                        <small class="{{ $message->sender_id === Auth::id() ? 'text-white-50' : 'text-muted' }}">
                            {{ $message->formatted_created_at }}
                            @if($message->sender_id === Auth::id())
                                <i class="bi bi-check2-all ms-1"></i>
                            @endif
                        </small>
                    </div>
                @endforeach
            @else
                <div class="text-center text-muted py-5">
                    <i class="bi bi-chat-dots display-4"></i>
                    <p class="mt-3">Mulai percakapan Anda</p>
                </div>
            @endif
        </div>
        <div class="card-footer bg-white">
            <form action="{{ route('messages.store') }}" method="POST">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $user->id }}">
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="input-group">
                    <input type="text" name="message" class="form-control" 
                           placeholder="Tulis pesan Anda..." required autofocus>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send me-1"></i>Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto scroll to bottom of chat
    document.addEventListener('DOMContentLoaded', function() {
        const chatContainer = document.getElementById('chat-container');
        chatContainer.scrollTop = chatContainer.scrollHeight;
    });
</script>
@endpush
@endsection
