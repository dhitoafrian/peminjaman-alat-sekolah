@extends('layouts.app')

@section('title', 'Data Alat')
@section('page-title', 'Kelola Data Alat')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="card-title fw-bold mb-0">Daftar Inventaris</h5>
            <a href="{{ route('admin.alat.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Tambah Alat
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">Gambar</th>
                        <th>Nama Alat</th>
                        <th>Deskripsi</th>
                        <th class="text-center">Stok</th>
                        <th class="text-center" width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($alats as $alat)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if($alat->foto)
                                    <img src="{{ asset('storage/'.$alat->foto) }}" alt="{{ $alat->nama }}"
                                         class="img-thumbnail rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted border"
                                         style="width: 60px; height: 60px;">
                                        <i class="bi bi-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="fw-medium">{{ $alat->nama }}</td>
                            <td class="text-muted small">{{ Str::limit($alat->deskripsi, 50) }}</td>
                            <td class="text-center">
                                @if($alat->stok > 0)
                                    <span class="badge bg-success bg-opacity-10 text-success px-3">
                                        {{ $alat->stok }} Unit
                                    </span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-3">
                                        Habis
                                    </span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.alat.edit', $alat->id) }}" class="btn btn-sm btn-warning text-white">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form action="{{ route('admin.alat.destroy', $alat->id) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus alat ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-box-seam fs-1 d-block mb-2"></i>
                                Belum ada data alat tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
