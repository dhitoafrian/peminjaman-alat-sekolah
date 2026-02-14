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

                        <a href="{{ route('admin.peminjaman.index', ['status' => 'pending_return']) }}"
                            class="btn btn-sm {{ request('status') == 'pending_return' ? 'btn-info text-white' : 'btn-outline-info text-dark' }}">
                            <i class="bi bi-clock-history"></i> Menunggu Konfirmasi
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
                                    <th>Jumlah</th>
                                    <th>Keterangan</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Deadline</th>
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
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                @if ($peminjaman->alat->foto)
                                                    <img src="{{ asset('storage/' . $peminjaman->alat->foto) }}"
                                                        class="rounded"
                                                        style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                        Style="width: 40px; height: 40px;">
                                                        <i class="bi bi-image text-muted"></i>
                                                    </div>
                                                @endif
                                                <span class="fw-medium">{{ $peminjaman->alat->nama }}</span>
                                            </div>
                                        </td>
                                        <td>{{ $peminjaman->jumlah }}</td>
                                        <td>
                                            <div class="small fw-bold">{{ $peminjaman->keterangan }}</div>
                                        </td>
                                        <td>{{ $peminjaman->tgl_pinjam->format('d M Y') }}</td>
                                        <td>
                                            @if ($peminjaman->tgl_kembali_admin)
                                                {{ $peminjaman->tgl_kembali_admin->format('d M Y') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($peminjaman->tgl_pengembalian_user)
                                                {{ $peminjaman->tgl_pengembalian_user->format('d M Y') }}
                                                @if ($peminjaman->tgl_pengembalian_user > $peminjaman->tgl_kembali_admin)
                                                    <br><span class="badge bg-warning">Telat</span>
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if ($peminjaman->status == 'pending')
                                                <span class="badge bg-warning text-dark">Menunggu</span>
                                            @elseif($peminjaman->status == 'approved')
                                                <span class="badge bg-primary">Sedang Pinjam</span>
                                            @elseif($peminjaman->status == 'pending_return')
                                                <span class="badge bg-info text-dark">Menunggu Konfirmasi</span>
                                            @elseif($peminjaman->status == 'returned')
                                                <span class="badge bg-success">Dikembalikan</span>
                                            @elseif($peminjaman->status == 'rejected')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">

                                                {{-- LOGIKA TOMBOL BERDASARKAN STATUS --}}

                                                {{-- 1. Jika Pending: Tampilkan Tombol Approve & Reject --}}
                                                @if ($peminjaman->status == 'pending')
                                                    <button type="button" class="btn btn-sm btn-success"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#approveModal{{ $peminjaman->id }}">
                                                        <i class="bi bi-check-lg"></i>
                                                    </button>

                                                    <form action="{{ route('admin.peminjaman.reject', $peminjaman->id) }}"
                                                        method="POST">
                                                        @csrf @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Tolak peminjaman ini?')">
                                                            <i class="bi bi-x-lg"></i>
                                                        </button>
                                                    </form>


                                                    {{-- Modal untuk pilih durasi --}}
                                                    <div class="modal fade" id="approveModal{{ $peminjaman->id }}"
                                                        tabindex="-1">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Setujui Peminjaman</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <form
                                                                    action="{{ route('admin.peminjaman.approve', $peminjaman->id) }}"
                                                                    method="POST">
                                                                    @csrf @method('PATCH')
                                                                    <div class="modal-body">
                                                                        <p>Setujui peminjaman
                                                                            <strong>{{ $peminjaman->alat->nama }}</strong>
                                                                            oleh
                                                                            <strong>{{ $peminjaman->user->name }}</strong>?
                                                                        </p>

                                                                        <div class="mb-3">
                                                                            <label class="form-label">Durasi
                                                                                Peminjaman</label>
                                                                            <select name="durasi_hari" class="form-select"
                                                                                required>
                                                                                <option value="">Pilih durasi...
                                                                                </option>
                                                                                <option value="1">1 Hari</option>
                                                                                <option value="3" selected>3 Hari
                                                                                </option>
                                                                                <option value="7">1 Minggu (7 Hari)
                                                                                </option>
                                                                                <option value="14">2 Minggu (14 Hari)
                                                                                </option>
                                                                                <option value="30">1 Bulan (30 Hari) -
                                                                                    Maksimal</option>
                                                                            </select>
                                                                            <small class="text-muted">Atau tentukan tanggal
                                                                                langsung:</small>
                                                                            <input type="date" name="tgl_kembali_custom"
                                                                                class="form-control mt-2"
                                                                                min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Setujui</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif($peminjaman->status == 'pending_return')
                                                    <form
                                                        action="{{ route('admin.peminjaman.confirm-return', $peminjaman->id) }}"
                                                        method="POST">
                                                        @csrf @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-success"
                                                            onclick="return confirm('Konfirmasi penerimaan alat ini?')">
                                                            <i class="bi bi-check-circle"></i> Terima
                                                        </button>
                                                    </form>

                                                    {{-- APPROVED: Tidak ada aksi (menunggu user ajukan kembali) --}}
                                                @elseif($peminjaman->status == 'approved')
                                                    <span class="text-muted">-</span>

                                                    {{-- SELESAI/DITOLAK --}}
                                                @else
                                                    <span class="text-muted">-</span>
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
