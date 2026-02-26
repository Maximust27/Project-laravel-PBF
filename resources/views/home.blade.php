@extends('layouts.app')

@section('title', 'Selamat Datang di Kampus Marketplace')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3">Kampus Marketplace</h1>
        <p class="lead mb-4">Platform jual beli barang akademik untuk mahasiswa, dosen, dan staf kampus</p>
        
        <!-- Search Box -->
        <form action="{{ route('products.index') }}" method="GET" class="search-box">
            <div class="input-group">
                <input type="text" name="search" class="form-control form-control-lg" 
                       placeholder="Cari barang akademik..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-light btn-lg">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>
    </div>
</section>

<!-- Features Section -->
<section class="container mb-5">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100 text-center p-4 dashboard-card">
                <div class="card-body">
                    <i class="bi bi-shop display-4 text-primary mb-3"></i>
                    <h4>Jual Barang</h4>
                    <p class="text-muted mb-0">Jual barang akademik yang tidak terpakai kepada mahasiswa lainnya.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 text-center p-4 dashboard-card">
                <div class="card-body">
                    <i class="bi bi-cart display-4 text-success mb-3"></i>
                    <h4>Beli Barang</h4>
                    <p class="text-muted mb-0">Temukan barang akademik yang Anda butuhkan dengan harga terjangkau.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 text-center p-4 dashboard-card">
                <div class="card-body">
                    <i class="bi bi-chat-dots display-4 text-info mb-3"></i>
                    <h4>Chat Langsung</h4>
                    <p class="text-muted mb-0">Hubungi penjual langsung untuk negosiasi harga dan detail barang.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Latest Products Section -->
<section class="container mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="bi bi-clock-history me-2"></i>Produk Terbaru</h2>
        <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
            Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>
    
    @if($latestProducts->count() > 0)
        <div class="row g-4">
            @foreach($latestProducts as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card product-card h-100">
                        <img src="{{ $product->foto_url }}" class="card-img-top" alt="{{ $product->nama_barang }}">
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
    @else
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <h4>Belum ada produk</h4>
            <p class="text-muted">Jadilah yang pertama menjual barang di Kampus Marketplace!</p>
            @auth
                <a href="{{ route('products.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-2"></i>Tambah Produk
                </a>
            @else
                <a href="{{ route('register') }}" class="btn btn-primary">
                    <i class="bi bi-person-plus me-2"></i>Daftar Sekarang
                </a>
            @endauth
        </div>
    @endif
</section>

<!-- CTA Section -->
<section class="container mb-5">
    <div class="card bg-primary text-white">
        <div class="card-body p-5 text-center">
            <h2 class="mb-3">Siap untuk mulai berjualan?</h2>
            <p class="lead mb-4">Daftar gratis dan jual barang akademik Anda sekarang!</p>
            @auth
                <a href="{{ route('products.create') }}" class="btn btn-light btn-lg">
                    <i class="bi bi-plus-lg me-2"></i>Tambah Produk
                </a>
            @else
                <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                    <i class="bi bi-person-plus me-2"></i>Daftar Gratis
                </a>
            @endauth
        </div>
    </div>
</section>
@endsection
