@extends('layouts.app')

@section('title', 'Data Peminjaman')
@section('page-title', 'Kelola Peminjaman')

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <div class="card-body">

                    <div class="d-flex flex-wrap gap-2 mb-4">
                        {{-- Tombol Semua --}}
                        <a href="{{ route('admin.peminjaman.index') }}"
                            class="btn btn-sm {{ request('status') == null ? 'btn-primary' : 'btn-outline-primary' }}">
                            <i class="bi bi-grid"></i> Semua
                        </a>

                        {{-- Tombol Menunggu --}}
                        <a href="{{ route('admin.peminjaman.index', ['status' => 'pending']) }}"
                            class="btn btn-sm {{ request('status') == 'pending' ? 'btn-warning text-dark' : 'btn-outline-warning text-dark' }}">
                            <i class="bi bi-hourglass-split"></i> Menunggu
                        </a>

                        {{-- Tombol Sedang Pinjam --}}
                        <a href="{{ route('admin.peminjaman.index', ['status' => 'approved']) }}"
                            class="btn btn-sm {{ request('status') == 'approved' ? 'btn-info text-white' : 'btn-outline-info text-dark' }}">
                            <i class="bi bi-box-arrow-right"></i> Sedang Pinjam
                        </a>

                        {{-- Tombol Dikembalikan --}}
                        <a href="{{ route('admin.peminjaman.index', ['status' => 'returned']) }}"
                            class="btn btn-sm {{ request('status') == 'returned' ? 'btn-success' : 'btn-outline-success' }}">
                            <i class="bi bi-check-circle"></i> Selesai
                        </a>

                        {{-- Tombol Ditolak --}}
                        <a href="{{ route('admin.peminjaman.index', ['status' => 'rejected']) }}"
                            class="btn btn-sm {{ request('status') == 'rejected' ? 'btn-danger' : 'btn-outline-danger' }}">
                            <i class="bi bi-x-circle"></i> Ditolak
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Peminjam</th>
                                    <th>Alat</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($peminjamans as $peminjaman)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-2 bg-secondary text-white rounded-circle text-center"
                                                    style="width: 30px; height: 30px; line-height: 30px;">
                                                    {{ substr($peminjaman->user->name, 0, 1) }}
                                                </div>
                                                <span class="fw-medium">{{ $peminjaman->user->name }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $peminjaman->alat->nama_alat }}</td>
                                        <td>{{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->format('d M Y') }}</td>
                                        <td>
                                            @if ($peminjaman->tgl_kembali)
                                                {{ \Carbon\Carbon::parse($peminjaman->tgl_kembali)->format('d M Y') }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($peminjaman->status == 'pending')
                                                <span class="badge bg-warning text-dark">Menunggu</span>
                                            @elseif($peminjaman->status == 'approved')
                                                <span class="badge bg-primary">Sedang Pinjam</span>
                                            @elseif($peminjaman->status == 'rejected')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @elseif($peminjaman->status == 'returned')
                                                <span class="badge bg-success">Dikembalikan</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">

                                                {{-- LOGIKA TOMBOL BERDASARKAN STATUS --}}

                                                {{-- 1. Jika Pending: Tampilkan Tombol Approve & Reject --}}
                                                @if ($peminjaman->status == 'pending')
                                                    <form action="{{ route('admin.peminjaman.approve', $peminjaman->id) }}"
                                                        method="POST">
                                                        @csrf @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-success"
                                                            onclick="return confirm('Setujui peminjaman ini?')">
                                                            <i class="bi bi-check-lg"></i>
                                                        </button>
                                                    </form>

                                                    <form action="{{ route('admin.peminjaman.reject', $peminjaman->id) }}"
                                                        method="POST">
                                                        @csrf @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Tolak peminjaman ini?')">
                                                            <i class="bi bi-x-lg"></i>
                                                        </button>
                                                    </form>

                                                    {{-- 2. Jika Approved: Tampilkan Tombol Kembalikan --}}
                                                @elseif($peminjaman->status == 'approved')
                                                    <form action="{{ route('admin.peminjaman.return', $peminjaman->id) }}"
                                                        method="POST">
                                                        @csrf @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-info text-white"
                                                            onclick="return confirm('Konfirmasi pengembalian alat?')">
                                                            <i class="bi bi-box-arrow-in-down"></i> Kembalikan
                                                        </button>
                                                    </form>

                                                    {{-- 3. Jika Selesai/Ditolak: Tidak ada aksi --}}
                                                @else
                                                    <button class="btn btn-sm btn-secondary" disabled>Selesai</button>
                                                @endif

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                            Belum ada data peminjaman
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endsection
