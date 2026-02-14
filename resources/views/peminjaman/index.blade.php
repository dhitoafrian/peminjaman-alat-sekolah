@extends('layouts.app')

@section('title', 'Riwayat Peminjaman')
@section('page-title', 'Riwayat Peminjaman Saya')

@section('content')
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Alat</th>
                            <th>Tanggal Pinjam</th>
                            <th>Deadline Kembali</th>
                            <th>Tanggal Kembali</th>
                            <th>Keterangan</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjamans as $pinjam)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        {{-- Perhatikan: Kita pakai $pinjam->alat, bukan $alat langsung --}}
                                        @if ($pinjam->alat->foto)
                                            <img src="{{ asset('storage/' . $pinjam->alat->foto) }}" class="rounded"
                                                style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                style="width: 40px; height: 40px;">
                                                <i class="bi bi-image text-muted"></i>
                                            </div>
                                        @endif
                                        <span class="fw-medium">{{ $pinjam->alat->nama }}</span>
                                    </div>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($pinjam->tgl_pinjam)->format('d M Y') }}</td>
                                <td>
                                    @if ($pinjam->tgl_kembali_admin)
                                        {{ \Carbon\Carbon::parse($pinjam->tgl_kembali_admin)->format('d M Y') }}
                                        @if ($pinjam->status == 'approved' && now()->gt($pinjam->tgl_kembali_admin))
                                            <br><span class="badge bg-danger">Telat</span>
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($pinjam->tgl_pengembalian_user)
                                        {{ \Carbon\Carbon::parse($pinjam->tgl_pengembalian_user)->format('d/m/Y') }}
                                        @if ($pinjam->tgl_pengembalian_user > $pinjam->tgl_kembali_admin)
                                            <br><span class="badge bg-warning text-dark">Telat</span>
                                        @endif
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="small text-muted">{{ Str::limit($pinjam->keterangan, 30) }}</td>
                                <td class="text-center">
                                    @if ($pinjam->status == 'pending')
                                        <span class="badge bg-warning text-dark">Menunggu Persetujuan</span>
                                    @elseif($pinjam->status == 'approved')
                                        <div class="d-flex flex-column align-items-center gap-2">
                                            <span class="badge bg-primary">Sedang Dipinjam</span>
                                            <form action="{{ route('peminjaman.request-return', $pinjam->id) }}"
                                                method="POST">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-warning text-dark"
                                                    onclick="return confirm('Yakin ingin mengajukan pengembalian?')">
                                                    <i class="bi bi-box-arrow-left"></i> Ajukan Kembali
                                                </button>
                                            </form>
                                        </div>
                                    @elseif($pinjam->status == 'pending_return')
                                        <span class="badge bg-info">Menunggu Konfirmasi Admin</span>
                                    @elseif($pinjam->status == 'returned')
                                        <span class="badge bg-success">Selesai</span>
                                    @elseif($pinjam->status == 'rejected')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-clock-history fs-1 d-block mb-2"></i>
                                    Belum ada riwayat peminjaman.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
