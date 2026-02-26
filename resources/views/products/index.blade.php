@extends('layouts.app')

@section('title', 'Semua Produk - Kampus Marketplace')

@section('content')
<div class="container py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1"><i class="bi bi-grid me-2"></i>Semua Produk</h2>
            <p class="text-muted mb-0">Temukan barang akademik yang Anda butuhkan</p>
        </div>
        @auth
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>Jual Barang
        </a>
        @endauth
    </div>

    <!-- Search Bar -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('products.index') }}" method="GET">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0" 
                           placeholder="Cari nama barang..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">Cari</button>
                    @if(request('search'))
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-lg"></i> Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Products Grid -->
    @if($products->count() > 0)
        <div class="row g-4">
            @foreach($products as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card product-card h-100">
                        <img src="{{ Storage::url($product->foto_url) }}" class="card-img-top" alt="{{ $product->nama_barang }}">
                        <div class="card-body">
                            <span class="badge {{ $product->kondisi == 'baru' ? 'bg-success' : 'bg-warning text-dark' }} condition-badge mb-2">
                                {{ ucfirst($product->kondisi) }}
                            </span>
                            <h5 class="card-title text-truncate">{{ $product->nama_barang }}</h5>
                            <p class="price-tag mb-2">{{ $product->formatted_harga }}</p>
                            <p class="card-text text-muted small text-truncate">
                                <i class="bi bi-person me-1"></i>{{ $product->user->name }}
                            </p>
                            <a href="{{ route('products.show', $product) }}" class="btn btn-primary btn-sm w-100">
                                <i class="bi bi-eye me-1"></i>Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $products->withQueryString()->links() }}
        </div>
    @else
        <div class="empty-state">
            <i class="bi bi-search"></i>
            <h4>Tidak ada produk ditemukan</h4>
            <p class="text-muted">
                @if(request('search'))
                    Tidak ada produk yang cocok dengan pencarian "{{ request('search') }}"
                @else
                    Belum ada produk yang tersedia
                @endif
            </p>
            @if(request('search'))
                <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                    <i class="bi bi-arrow-left me-2"></i>Kembali ke Semua Produk
                </a>
            @endif
        </div>
    @endif
</div>
@endsection
