@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Overview Sistem')

@section('content')

<div class="row g-4 mb-4">
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-primary bg-opacity-10 p-3 rounded-circle text-primary">
                    <i class="bi bi-box-seam fs-4"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-0 small text-uppercase fw-bold">Total Aset</h6>
                    <h3 class="fw-bold mb-0">{{ $totalAlat }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-warning bg-opacity-10 p-3 rounded-circle text-warning">
                    <i class="bi bi-box-arrow-right fs-4"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-0 small text-uppercase fw-bold">Sedang Dipinjam</h6>
                    <h3 class="fw-bold mb-0">{{ $sedangDipinjam }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100 {{ $permintaanPending > 0 ? 'border-danger border-2' : '' }}">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-danger bg-opacity-10 p-3 rounded-circle text-danger">
                    <i class="bi bi-exclamation-circle fs-4"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-0 small text-uppercase fw-bold">Butuh Persetujuan</h6>
                    <h3 class="fw-bold mb-0">{{ $permintaanPending }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-success bg-opacity-10 p-3 rounded-circle text-success">
                    <i class="bi bi-people fs-4"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-0 small text-uppercase fw-bold">Siswa Terdaftar</h6>
                    <h3 class="fw-bold mb-0">{{ $totalUser }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold">📝 Permintaan Peminjaman Masuk</h6>
                <a href="{{ route('admin.peminjaman.index', ['status' => 'pending']) }}" class="btn btn-sm btn-light">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Siswa</th>
                                <th>Alat</th>
                                <th>Tgl Pinjam</th>
                                <th class="text-end pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestPeminjamans as $item)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-xs bg-secondary bg-opacity-10 rounded-circle text-center me-2" style="width:30px; height:30px; line-height:30px;">
                                                {{ substr($item->user->name, 0, 1) }}
                                            </div>
                                            <span class="fw-medium small">{{ $item->user->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $item->alat->nama }}</td>
                                    <td class="small text-muted">{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('d/m/Y') }}</td>
                                    <td class="text-end pe-4">
                                        <form action="{{ route('admin.peminjaman.approve', $item->id) }}" method="POST" class="d-inline">
                                            @csrf @method('PATCH')
                                            <button class="btn btn-sm btn-success py-0 px-2" title="Terima"><i class="bi bi-check"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted small">
                                        Tidak ada permintaan baru hari ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold text-danger"><i class="bi bi-lightning-charge-fill me-1"></i> Stok Menipis</h6>
            </div>
            <div class="card-body">
                @forelse($stokMenipis as $alat)
                    <div class="d-flex align-items-center mb-3">
                        <div class="me-3 position-relative">
                            @if($alat->foto)
                                <img src="{{ asset('storage/'.$alat->foto) }}" class="rounded" style="width: 40px; height: 40px; object-fit:cover;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="bi bi-tools text-muted"></i></div>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0 small fw-bold">{{ $alat->nama }}</h6>
                            <small class="text-danger">Sisa: {{ $alat->stok }} Unit</small>
                        </div>
                        <a href="{{ route('admin.alat.edit', $alat->id) }}" class="btn btn-sm btn-outline-secondary py-0">
                            Restock
                        </a>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted small">
                        <i class="bi bi-emoji-smile d-block fs-3 mb-2"></i>
                        Stok alat aman terkendali.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
