@extends('layouts.app')

@section('title', 'Kirim Pesan - ' . $product->nama_barang . ' - Kampus Marketplace')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Product Info -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <img src="{{ $product->foto_url }}" alt="{{ $product->nama_barang }}" 
                                 class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mb-1">{{ $product->nama_barang }}</h5>
                            <p class="price-tag mb-1">{{ $product->formatted_harga }}</p>
                            <p class="text-muted small mb-0">
                                <i class="bi bi-person me-1"></i>Penjual: {{ $product->user->name }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Message Form -->
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-chat-dots me-2"></i>Kirim Pesan ke Penjual</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('messages.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="receiver_id" value="{{ $product->user_id }}">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="mb-3">
                            <label for="message" class="form-label">Pesan Anda</label>
                            <textarea class="form-control @error('message') is-invalid @enderror" 
                                      id="message" name="message" rows="5" required
                                      placeholder="Halo, saya tertarik dengan produk ini..."></textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-send me-2"></i>Kirim Pesan
                            </button>
                            <a href="{{ route('products.show', $product) }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tips -->
            <div class="alert alert-info mt-4">
                <h6><i class="bi bi-lightbulb me-2"></i>Tips:</h6>
                <ul class="mb-0">
                    <li>Tanyakan kondisi barang dengan detail</li>
                    <li>Tanyakan lokasi untuk meetup/pengiriman</li>
                    <li>Negosiasi harga dengan sopan</li>
                    <li>Pastikan barang sesuai sebelum membayar</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
