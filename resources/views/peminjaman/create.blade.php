@extends('layouts.app')

@section('title', 'Form Peminjaman')
@section('page-title', 'Ajukan Peminjaman')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="row g-0">
                    <div class="col-md-5 bg-light d-flex align-items-center justify-content-center p-4">
                        <div class="text-center">
                            @if ($alat->foto)
                                <img src="{{ asset('storage/' . $alat->foto) }}" class="img-fluid rounded shadow-sm mb-3"
                                    style="max-height: 250px;">
                            @else
                                <i class="bi bi-box-seam fs-1 text-secondary d-block mb-3"></i>
                            @endif
                            <h4 class="fw-bold mb-1">{{ $alat->nama }}</h4>
                            <span class="badge bg-success bg-opacity-10 text-success mb-3">
                                Stok Tersedia: {{ $alat->stok }}
                            </span>
                            <p class="text-muted small px-3">{{ $alat->deskripsi }}</p>
                        </div>
                    </div>

                    <div class="col-md-7 p-5">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold mb-0">Formulir Peminjaman</h5>
                            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary">Batal</a>
                        </div>

                        <form action="{{ route('peminjaman.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="alat_id" value="{{ $alat->id }}">

                            <div class="mb-3">
                                <label class="form-label text-muted small text-uppercase fw-bold">Peminjam</label>
                                <input type="text" class="form-control bg-light" value="{{ auth()->user()->name }}"
                                    readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted small text-uppercase fw-bold">Jumlah Alat</label>
                                <input type="number" name="jumlah" class="form-control" value="1" min="1"
                                    max="{{ $alat->stok }}" required>
                                <div class="form-text">Maksimal pinjam: {{ $alat->stok }} unit</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-muted small text-uppercase fw-bold">Tanggal Pinjam</label>
                                <input type="text" class="form-control bg-light" value="{{ now()->format('d M Y') }}"
                                    readonly>
                                <div class="form-text">Tanggal pinjam otomatis diset hari ini.</div>
                            </div>

                            <div class="mb-4">
                                <label for="keterangan" class="form-label text-muted small text-uppercase fw-bold">Keperluan
                                    / Keterangan</label>
                                <textarea name="keterangan" id="keterangan" rows="3" class="form-control"
                                    placeholder="Contoh: Untuk praktek mapel Fisika kelas XII RPL 1" required></textarea>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary py-2">
                                    <i class="bi bi-send me-2"></i> Ajukan Peminjaman
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
