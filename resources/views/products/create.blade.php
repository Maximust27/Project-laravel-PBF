@extends('layouts.app')

@section('title', 'Tambah Produk - Kampus Marketplace')

@section('content')
<div class="container py-4">
    <!-- Page Header -->
    <div class="mb-4">
        <h2 class="mb-1"><i class="bi bi-plus-lg me-2"></i>Tambah Produk</h2>
        <p class="text-muted mb-0">Jual barang akademik Anda</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body p-4">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="nama_barang" class="form-label">Nama Barang <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_barang') is-invalid @enderror" 
                                   id="nama_barang" name="nama_barang" value="{{ old('nama_barang') }}" required>
                            @error('nama_barang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      id="deskripsi" name="deskripsi" rows="4" required>{{ old('deskripsi') }}</textarea>
                            <div class="form-text">Jelaskan kondisi dan detail barang Anda</div>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="harga" class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control @error('harga') is-invalid @enderror" 
                                               id="harga" name="harga" value="{{ old('harga') }}" min="0" required>
                                    </div>
                                    @error('harga')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="stok" class="form-label">Stok Barang <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('stok') is-invalid @enderror" 
                                           id="stok" name="stok" value="{{ old('stok', 1) }}" min="1" required>
                                    <div class="form-text">Jumlah tersedia</div>
                                    @error('stok')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="kondisi" class="form-label">Kondisi <span class="text-danger">*</span></label>
                                    <select class="form-select @error('kondisi') is-invalid @enderror" 
                                            id="kondisi" name="kondisi" required>
                                        <option value="">Pilih Kondisi</option>
                                        <option value="baru" {{ old('kondisi') == 'baru' ? 'selected' : '' }}>Baru</option>
                                        <option value="bekas" {{ old('kondisi') == 'bekas' ? 'selected' : '' }}>Bekas</option>
                                    </select>
                                    @error('kondisi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="foto" class="form-label">Foto Produk</label>
                            <input type="file" class="form-control @error('foto') is-invalid @enderror" 
                                   id="foto" name="foto" accept="image/*">
                            <div class="form-text">Format: JPG, PNG, GIF. Maksimal 2MB</div>
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i>Simpan Produk
                            </button>
                            <a href="{{ route('products.my') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-lg me-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection