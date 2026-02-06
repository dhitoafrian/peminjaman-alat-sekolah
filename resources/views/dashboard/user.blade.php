@extends('layouts.app')

@section('title', 'Katalog Alat')
@section('page-title', 'Katalog Peminjaman')

@section('content')

<div class="row mb-4">
    <div class="col-md-8 mx-auto">
        <form action="{{ route('dashboard') }}" method="GET">
            <div class="input-group shadow-sm">
                <input type="text" name="search" class="form-control border-0 py-3 ps-4"
                       placeholder="Cari alat apa? (Misal: Kamera, Kabel...)"
                       value="{{ request('search') }}">
                <button class="btn btn-primary px-4" type="submit">
                    <i class="bi bi-search"></i> Cari
                </button>
            </div>
        </form>
    </div>
</div>

<div class="row g-4">
    @forelse($alats as $alat)
        <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-stretch">
            {{-- Class 'd-flex align-items-stretch' wajib biar tinggi card sama rata --}}

            <div class="card w-100 border-0 shadow-sm">

                <div style="height: 200px; overflow: hidden; position: relative;">
                    @if($alat->foto)
                        <img src="{{ asset('storage/'.$alat->foto) }}"
                             alt="{{ $alat->nama }}"
                             class="w-100 h-100"
                             style="object-fit: cover;"> {{-- Kunci biar gambar ga gepeng --}}
                    @else
                        <div class="w-100 h-100 bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center text-muted">
                            <i class="bi bi-image fs-1"></i>
                        </div>
                    @endif

                    <div class="position-absolute top-0 end-0 m-2">
                        @if($alat->stok > 0)
                            <span class="badge bg-success bg-opacity-75 backdrop-blur">
                                Ready: {{ $alat->stok }}
                            </span>
                        @else
                            <span class="badge bg-danger bg-opacity-75 backdrop-blur">
                                Habis
                            </span>
                        @endif
                    </div>
                </div>

                <div class="card-body d-flex flex-column p-4">
                    <h5 class="card-title fw-bold text-dark mb-2">{{ $alat->nama }}</h5>

                    {{-- Deskripsi dibatasin 2 baris aja biar rapi --}}
                    <p class="card-text text-muted small flex-grow-1 mb-4"
                       style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                        {{ $alat->deskripsi ?? 'Tidak ada deskripsi alat.' }}
                    </p>

                    <div class="mt-auto">
                        @if($alat->stok > 0)
                            {{-- INI TOMBOL AKSINYA --}}
                            {{-- Mengarah ke Route: peminjaman.create dengan membawa ID alat --}}
                            <a href="{{ route('peminjaman.create', $alat->id) }}" class="btn btn-primary w-100 fw-medium py-2">
                                <i class="bi bi-bag-plus me-1"></i> Pinjam
                            </a>
                        @else
                            <button class="btn btn-light w-100 text-muted border" disabled>
                                Stok Habis
                            </button>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <div class="mb-3">
                <i class="bi bi-box-seam fs-1 text-muted"></i>
            </div>
            <h5 class="text-muted">Alat tidak ditemukan</h5>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-sm mt-2">Reset Pencarian</a>
        </div>
    @endforelse
</div>

{{-- CSS Tambahan Dikit buat Backdrop Blur Badge --}}
<style>
    .backdrop-blur {
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
    }
</style>
@endsection
