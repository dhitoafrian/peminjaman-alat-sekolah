<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    // A. Riwayat peminjaman user
    public function index()
    {
        $peminjamans = Peminjaman::where('user_id', auth()->id())
            ->with('alat')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('peminjaman.index', compact('peminjamans'));
    }

    // B. Form pinjam alat
    public function create($alat_id)
    {
        $alat = Alat::findOrFail($alat_id);

        // Cek stok
        if ($alat->stok <= 0) {
            return redirect()->back()->with('error', 'Stok alat habis, tidak bisa dipinjam.');
        }

        return view('peminjaman.create', compact('alat'));
    }

    // C. Simpan pengajuan peminjaman
    public function store(Request $request)
    {
        $request->validate([
            'alat_id' => 'required|exists:alats,id',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'required|string|max:255',
        ]);

        // Cek stok sekali lagi
        $alat = Alat::findOrFail($request->alat_id);

        if ($alat->stok <= 0) {
            return redirect()->back()->with('error', 'Stok tidak cukup! sisa stok: ' . $alat->stok);
        }

        // Simpan peminjaman dengan status pending
        Peminjaman::create([
            'user_id' => auth()->id(),
            'alat_id' => $request->alat_id,
            'jumlah' => $request->jumlah,
            'keterangan' => $request->keterangan,
            'tgl_pinjam' => now(),
            'status' => 'pending',
            'keterangan' => $request->keterangan
        ]);

        return redirect()->route('peminjaman.index')
            ->with('success', 'Pengajuan peminjaman berhasil diajukan. Menunggu persetujuan admin.');
    }

    public function requestReturn($id)
    {
        $peminjaman = Peminjaman::where('user_id', auth()->id())->where('status', 'approved')->findOrFail($id);

        $peminjaman->update([
            'status' => 'pending_return',
            'tgl_pengembalian_user' => now()->format('Y-m-d'),
        ]);

        return back()->with('success', 'Pengembalian diajukan, menunggu konfirmasi admin');
    }
}
