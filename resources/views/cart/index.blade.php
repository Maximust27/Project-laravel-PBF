@extends('layouts.app')

@section('title', 'Keranjang Belanja - Kampus Marketplace')

@section('content')
<div class="container py-4">
    <!-- Page Header -->
    <div class="mb-4">
        <h2 class="mb-1"><i class="bi bi-cart me-2"></i>Keranjang Belanja</h2>
        <p class="text-muted mb-0">Kelola barang yang ingin Anda beli</p>
    </div>

    @if($carts->count() > 0)
        <div class="row g-4">
            <!-- Cart Items -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ $carts->count() }} Produk</h5>
                            <form action="{{ route('cart.clear') }}" method="POST" class="d-inline" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin mengosongkan keranjang?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash me-1"></i>Kosongkan
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        @foreach($carts as $cart)
                            <div class="row align-items-center mb-4 {{ !$loop->last ? 'pb-4 border-bottom' : '' }}">
                                <div class="col-3 col-md-2">
                                    <img src="{{ $cart->product->foto_url }}" alt="{{ $cart->product->nama_barang }}" 
                                         class="img-fluid rounded" style="height: 80px; object-fit: cover;">
                                </div>
                                <div class="col-9 col-md-4">
                                    <h6 class="mb-1">
                                        <a href="{{ route('products.show', $cart->product) }}" class="text-decoration-none">
                                            {{ $cart->product->nama_barang }}
                                        </a>
                                    </h6>
                                    <p class="text-muted small mb-0">
                                        <i class="bi bi-person me-1"></i>{{ $cart->product->user->name }}
                                    </p>
                                    <span class="badge {{ $cart->product->kondisi == 'baru' ? 'bg-success' : 'bg-warning text-dark' }} condition-badge">
                                        {{ ucfirst($cart->product->kondisi) }}
                                    </span>
                                </div>
                                <div class="col-6 col-md-3 mt-3 mt-md-0">
                                    <form action="{{ route('cart.update', $cart) }}" method="POST" class="d-flex align-items-center">
                                        @csrf
                                        @method('PUT')
                                        <div class="input-group input-group-sm">
                                            <button type="button" class="btn btn-outline-secondary" 
                                                    onclick="this.parentNode.querySelector('input').stepDown()">
                                                <i class="bi bi-dash"></i>
                                            </button>
                                            <input type="number" name="quantity" class="form-control text-center" 
                                                   value="{{ $cart->quantity }}" min="1" style="max-width: 60px;">
                                            <button type="button" class="btn btn-outline-secondary" 
                                                    onclick="this.parentNode.querySelector('input').stepUp()">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-outline-primary ms-2">
                                            <i class="bi bi-check"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="col-6 col-md-3 mt-3 mt-md-0 text-end">
                                    <p class="price-tag mb-1">{{ $cart->formatted_subtotal }}</p>
                                    <p class="text-muted small mb-0">{{ $cart->product->formatted_harga }} / item</p>
                                    <form action="{{ route('cart.destroy', $cart) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-link text-danger text-decoration-none">
                                            <i class="bi bi-trash me-1"></i>Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Ringkasan Belanja</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Harga</span>
                            <span class="fw-bold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-bold">Total</span>
                            <span class="price-tag">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('orders.checkout') }}" class="btn btn-primary w-100 btn-lg">
                            <i class="bi bi-bag-check me-2"></i>Checkout
                        </a>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                            <i class="bi bi-arrow-left me-2"></i>Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="empty-state">
            <i class="bi bi-cart-x"></i>
            <h4>Keranjang Kosong</h4>
            <p class="text-muted">Anda belum menambahkan produk ke keranjang. Yuk, mulai belanja!</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary">
                <i class="bi bi-grid me-2"></i>Lihat Produk
            </a>
        </div>
    @endif
</div>
@endsection
