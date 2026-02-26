@extends('layouts.app')

@section('title', 'Checkout - Kampus Marketplace')

@section('content')
<div class="container py-4">
    <!-- Page Header -->
    <div class="mb-4">
        <h2 class="mb-1"><i class="bi bi-bag-check me-2"></i>Checkout</h2>
        <p class="text-muted mb-0">Konfirmasi pesanan Anda</p>
    </div>

    <div class="row g-4">
        <!-- Order Items -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Produk yang Dibeli</h5>
                </div>
                <div class="card-body">
                    @foreach($carts as $cart)
                        <div class="row align-items-center mb-3 {{ !$loop->last ? 'pb-3 border-bottom' : '' }}">
                            <div class="col-2">
                                <img src="{{ $cart->product->foto_url }}" alt="{{ $cart->product->nama_barang }}" 
                                     class="img-fluid rounded" style="height: 60px; object-fit: cover;">
                            </div>
                            <div class="col-6">
                                <h6 class="mb-1">{{ $cart->product->nama_barang }}</h6>
                                <p class="text-muted small mb-0">{{ $cart->quantity }} x {{ $cart->product->formatted_harga }}</p>
                            </div>
                            <div class="col-4 text-end">
                                <p class="price-tag mb-0">{{ $cart->formatted_subtotal }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="alert alert-info mt-3">
                <i class="bi bi-info-circle me-2"></i>
                <strong>Catatan:</strong> Sistem ini tidak menggunakan payment gateway. 
                Pembayaran dilakukan secara langsung dengan penjual setelah checkout.
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
                        <span>Total Harga ({{ $carts->sum('quantity') }} item)</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-bold">Total Bayar</span>
                        <span class="price-tag">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100 btn-lg" 
                                onclick="return confirm('Apakah Anda yakin ingin membuat pesanan ini?')">
                            <i class="bi bi-check-circle me-2"></i>Buat Pesanan
                        </button>
                    </form>

                    <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                        <i class="bi bi-arrow-left me-2"></i>Kembali ke Keranjang
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
