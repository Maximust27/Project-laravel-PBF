@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->id . ' - Kampus Marketplace')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Pesanan Saya</a></li>
            <li class="breadcrumb-item active">Pesanan #{{ $order->id }}</li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1"><i class="bi bi-bag me-2"></i>Detail Pesanan #{{ $order->id }}</h2>
            <p class="text-muted mb-0">{{ $order->created_at->format('d M Y H:i') }}</p>
        </div>
        <span class="{{ $order->status_badge_class }} fs-6">
            {{ $order->status_label }}
        </span>
    </div>

    <div class="row g-4">
        <!-- Order Items -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Produk Dipesan</h5>
                </div>
                <div class="card-body">
                    @foreach($order->orderItems as $item)
                        <div class="row align-items-center mb-4 {{ !$loop->last ? 'pb-4 border-bottom' : '' }}">
                            <div class="col-3 col-md-2">
                                <img src="{{ $item->product->foto_url }}" alt="{{ $item->product->nama_barang }}" 
                                     class="img-fluid rounded" style="height: 80px; object-fit: cover;">
                            </div>
                            <div class="col-9 col-md-6">
                                <h6 class="mb-1">
                                    <a href="{{ route('products.show', $item->product) }}" class="text-decoration-none">
                                        {{ $item->product->nama_barang }}
                                    </a>
                                </h6>
                                <p class="text-muted small mb-1">
                                    <i class="bi bi-person me-1"></i>Penjual: {{ $item->product->user->name }}
                                </p>
                                <span class="badge {{ $item->product->kondisi == 'baru' ? 'bg-success' : 'bg-warning text-dark' }} condition-badge">
                                    {{ ucfirst($item->product->kondisi) }}
                                </span>
                            </div>
                            <div class="col-6 col-md-2 mt-3 mt-md-0">
                                <p class="text-muted mb-0">{{ $item->quantity }} x {{ $item->formatted_harga }}</p>
                            </div>
                            <div class="col-6 col-md-2 mt-3 mt-md-0 text-end">
                                <p class="fw-bold mb-0">{{ $item->formatted_subtotal }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Timeline -->
            <div class="card mt-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Status Pesanan</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 40px; height: 40px;">
                                <i class="bi bi-check-lg"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">Pesanan Dibuat</h6>
                            <p class="text-muted small mb-0">{{ $order->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="border-start border-2 ms-5 my-2" style="height: 30px;"></div>
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="{{ $order->status === 'selesai' ? 'bg-success' : 'bg-warning' }} text-white rounded-circle d-flex align-items-center justify-content-center" 
                                 style="width: 40px; height: 40px;">
                                <i class="bi {{ $order->status === 'selesai' ? 'bi-check-lg' : 'bi-hourglass-split' }}"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">{{ $order->status === 'selesai' ? 'Pesanan Selesai' : 'Menunggu Konfirmasi' }}</h6>
                            <p class="text-muted small mb-0">
                                @if($order->status === 'selesai')
                                    Pesanan telah diselesaikan
                                @else
                                    Silakan hubungi penjual untuk konfirmasi pembayaran dan pengiriman
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Ringkasan Pesanan</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Ongkir</span>
                        <span class="text-success">Gratis</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-bold">Total</span>
                        <span class="price-tag">{{ $order->formatted_total_harga }}</span>
                    </div>

                    @if($order->status === 'pending')
                        <div class="alert alert-warning">
                            <i class="bi bi-info-circle me-2"></i>
                            Silakan hubungi penjual untuk pembayaran.
                        </div>
                        <form action="{{ route('orders.complete', $order) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success w-100" 
                                    onclick="return confirm('Tandai pesanan ini sebagai selesai?')">
                                <i class="bi bi-check-circle me-2"></i>Tandai Selesai
                            </button>
                        </form>
                    @else
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle me-2"></i>
                            Pesanan telah selesai. Terima kasih!
                        </div>
                    @endif
                </div>
            </div>

            <!-- Contact Sellers -->
            <div class="card mt-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Hubungi Penjual</h5>
                </div>
                <div class="card-body">
                    @php
                        $uniqueSellers = $order->orderItems->unique('product.user_id');
                    @endphp
                    @foreach($uniqueSellers as $item)
                        <div class="d-flex justify-content-between align-items-center mb-2 {{ !$loop->last ? 'pb-2 border-bottom' : '' }}">
                            <div>
                                <p class="mb-0 fw-bold">{{ $item->product->user->name }}</p>
                                <p class="text-muted small mb-0">{{ $item->product->nama_barang }}</p>
                            </div>
                            <a href="{{ route('messages.show', ['product' => $item->product, 'user' => $item->product->user]) }}" 
                               class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-chat-dots me-1"></i>Chat
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
