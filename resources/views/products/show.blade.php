@extends('layouts.app')

@section('title', $product->nama_barang . ' - Kampus Marketplace')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produk</a></li>
            <li class="breadcrumb-item active">{{ $product->nama_barang }}</li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Product Image -->
        <div class="col-md-5">
            <div class="card">
                <img src="{{ $product->foto_url }}" class="card-img-top" alt="{{ $product->nama_barang }}" 
                     style="height: 400px; object-fit: cover;">
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-md-7">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <span class="badge {{ $product->kondisi == 'baru' ? 'bg-success' : 'bg-warning text-dark' }} mb-2">
                                {{ ucfirst($product->kondisi) }}
                            </span>
                            <h2 class="mb-0">{{ $product->nama_barang }}</h2>
                        </div>
                        @if($product->user_id === Auth::id())
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('products.edit', $product) }}">
                                            <i class="bi bi-pencil me-2"></i>Edit
                                        </a>
                                    </li>
                                    <li>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bi bi-trash me-2"></i>Hapus
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @endif
                    </div>

                    <p class="price-tag display-6 mb-4">{{ $product->formatted_harga }}</p>

                    <div class="mb-4">
                        <h5>Deskripsi</h5>
                        <p class="text-muted">{{ $product->deskripsi }}</p>
                    </div>

                    <div class="mb-4">
                        <h5>Informasi Penjual</h5>
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="width: 50px; height: 50px;">
                                <i class="bi bi-person fs-4"></i>
                            </div>
                            <div>
                                <p class="mb-0 fw-bold">{{ $product->user->name }}</p>
                                <span class="badge bg-info">{{ ucfirst($product->user->role) }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        @auth
                            @if($product->user_id !== Auth::id())
                                <form action="{{ route('cart.store', $product) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-cart-plus me-2"></i>Tambah ke Keranjang
                                    </button>
                                </form>
                                <a href="{{ route('messages.create', $product) }}" class="btn btn-outline-primary btn-lg">
                                    <i class="bi bi-chat-dots me-2"></i>Chat Penjual
                                </a>
                            @else
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>Ini adalah produk Anda
                                </div>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Login untuk Membeli
                            </a>
                        @endauth
                    </div>

                    <hr class="my-4">

                    <div class="text-muted small">
                        <i class="bi bi-clock me-1"></i>Diposting {{ $product->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
