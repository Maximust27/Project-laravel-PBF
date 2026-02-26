@extends('layouts.app')

@section('title', 'Produk Saya - Kampus Marketplace')

@section('content')
<div class="container py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1"><i class="bi bi-box-seam me-2"></i>Produk Saya</h2>
            <p class="text-muted mb-0">Kelola produk yang Anda jual</p>
        </div>
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>Tambah Produk
        </a>
    </div>

    <!-- Products Table -->
    @if($products->count() > 0)
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Foto</th>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Kondisi</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>
                                    <img src="{{ Storage::url($product->foto_url) }}" alt="{{ $product->nama_barang }}" 
                                         class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                </td>
                                <td>
                                    <a href="{{ route('products.show', $product) }}" class="text-decoration-none fw-bold">
                                        {{ $product->nama_barang }}
                                    </a>
                                </td>
                                <td class="price-tag">{{ $product->formatted_harga }}</td>
                                <td>
                                    <span class="badge {{ $product->kondisi == 'baru' ? 'bg-success' : 'bg-warning text-dark' }}">
                                        {{ ucfirst($product->kondisi) }}
                                    </span>
                                </td>
                                <td>{{ $product->created_at->format('d M Y') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('products.destroy', $product) }}" method="POST" 
                                              class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $products->links() }}
        </div>
    @else
        <div class="empty-state">
            <i class="bi bi-box-seam"></i>
            <h4>Belum ada produk</h4>
            <p class="text-muted">Anda belum memiliki produk yang dijual. Mulai jual barang Anda sekarang!</p>
            <a href="{{ route('products.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-2"></i>Tambah Produk Pertama
            </a>
        </div>
    @endif
</div>
@endsection
