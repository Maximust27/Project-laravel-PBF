@extends('layouts.app')

@section('title', 'Pesanan Saya - Kampus Marketplace')

@section('content')
<div class="container py-4">
    <!-- Page Header -->
    <div class="mb-4">
        <h2 class="mb-1"><i class="bi bi-bag me-2"></i>Pesanan Saya</h2>
        <p class="text-muted mb-0">Riwayat pesanan Anda</p>
    </div>

    @if($orders->count() > 0)
        <div class="row g-4">
            @foreach($orders as $order)
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-muted">No. Pesanan:</span>
                                    <span class="fw-bold">#{{ $order->id }}</span>
                                    <span class="mx-2">|</span>
                                    <span class="text-muted">{{ $order->created_at->format('d M Y H:i') }}</span>
                                </div>
                                <span class="{{ $order->status_badge_class }}">
                                    {{ $order->status_label }}
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            @foreach($order->orderItems as $item)
                                <div class="row align-items-center mb-3 {{ !$loop->last ? 'pb-3 border-bottom' : '' }}">
                                    <div class="col-2 col-md-1">
                                        <img src="{{ $item->product->foto_url }}" alt="{{ $item->product->nama_barang }}" 
                                             class="img-fluid rounded" style="height: 50px; object-fit: cover;">
                                    </div>
                                    <div class="col-7 col-md-8">
                                        <h6 class="mb-1">{{ $item->product->nama_barang }}</h6>
                                        <p class="text-muted small mb-0">{{ $item->quantity }} x {{ $item->formatted_harga }}</p>
                                    </div>
                                    <div class="col-3 text-end">
                                        <p class="fw-bold mb-0">{{ $item->formatted_subtotal }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="card-footer bg-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-muted">Total Pesanan:</span>
                                    <span class="price-tag ms-2">{{ $order->formatted_total_harga }}</span>
                                </div>
                                <div>
                                    @if($order->status === 'pending')
                                        <form action="{{ route('orders.complete', $order) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm" 
                                                    onclick="return confirm('Tandai pesanan ini sebagai selesai?')">
                                                <i class="bi bi-check-circle me-1"></i>Tandai Selesai
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-eye me-1"></i>Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    @else
        <div class="empty-state">
            <i class="bi bi-bag-x"></i>
            <h4>Belum Ada Pesanan</h4>
            <p class="text-muted">Anda belum memiliki pesanan. Yuk, mulai belanja!</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary">
                <i class="bi bi-grid me-2"></i>Lihat Produk
            </a>
        </div>
    @endif
</div>
@endsection
