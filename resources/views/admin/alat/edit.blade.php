@extends('layouts.app')

@section('title', 'Tambah Alat')
@section('page-title', 'Tambah Alat Baru')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold">Form Input Alat</h6>
                        <a href="{{ route('admin.alat.index') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.alat.update', $alat->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="nama" class="form-label">Nama Alat</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    id="nama" name="nama" value="{{ old('nama', $alat->nama) }}"
                                    placeholder="Contoh: Proyektor Epson X500">
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="stok" class="form-label">Stok Awal</label>
                                <input type="number" class="form-control @error('stok') is-invalid @enderror"
                                    id="stok" name="stok" value="{{ old('stok', $alat->stok) }}" min="0">
                                @error('stok')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi / Spesifikasi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3"
                                placeholder="Jelaskan kondisi atau spesifikasi alat...">{{ old('deskripsi', $alat->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="foto" class="form-label">Foto Alat</label>
                            @if ($alat->foto)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $alat->foto) }}" alt="Foto Lama"
                                        class="img-thumbnail" style="width: 120px; height: auto; display: block;">
                                    <small class="text-muted">Foto saat ini</small>
                                </div>
                            @endif
                            <input class="form-control @error('foto') is-invalid @enderror" type="file" id="foto"
                                name="foto" accept="image/*">
                            <div class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB.</div>
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save me-1"></i> Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
