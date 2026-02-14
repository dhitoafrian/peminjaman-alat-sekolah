<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminPeminjamanController extends Controller
{
    // A. Lihat semua pengajuan peminjaman
    public function index(Request $request)
    {
        // 1. Siapkan Query Dasar (belum dieksekusi/get)
        $query = Peminjaman::with(['user', 'alat']);

        // 2. Cek apakah ada filter 'status' di URL?
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // 3. Eksekusi query dengan sorting
        $peminjamans = $query->orderBy('created_at', 'desc')->get();

        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    // B. Approve peminjaman
    public function approve(Request $request, $id)
    {
        // Validasi dulu
        $validated = $request->validate([
            'durasi_hari' => 'nullable|integer|min:1|max:30',
            'tgl_kembali_custom' => 'nullable|date|after:today',
        ]);

        if (!$request->filled('durasi_hari') && !$request->filled('tgl_kembali_custom')) {
            return back()->with('error', 'Pilih durasi atau isi tanggal kembali!');
        }

        $peminjaman = Peminjaman::findOrFail($id);

        if ($request->filled('tgl_kembali_custom')) {
            $tglKembali = $request->tgl_kembali_custom;
        } else {
            // ⭐ PAKSA JADI INTEGER!
            $durasi = intval($request->durasi_hari);
            $tglKembali = now()->addDays($durasi)->format('Y-m-d');
        }

        $alat = $peminjaman->alat;

        if ($alat->stok >= $peminjaman->jumlah) {
            $alat->decrement('stok', $peminjaman->jumlah);

            $peminjaman->update([
                'status' => 'approved',
                'tgl_kembali_admin' => $tglKembali,
            ]);

            return back()->with('success', 'Peminjaman berhasil disetujui.');
        }

        return back()->with('error', 'Stok tidak cukup.');
    }

    // C. Reject peminjaman
    public function reject($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        // Update status (stok TIDAK berubah)
        $peminjaman->update([
            'status' => 'rejected'
        ]);

        return redirect()->back()->with('success', 'Peminjaman ditolak.');
    }

    // Tambahan: Kembalikan alat (menambah stok kembali)
    public function confirmReturn($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'pending_return') {
            return redirect()->back()->with('error', 'tidak ada pengajuan pengembalian');
        }

        $peminjaman->alat->increment('stok', $peminjaman->jumlah);

        // Update peminjaman
        $peminjaman->update([
            'status' => 'returned',
            'tgl_pengembalian_user' => $peminjaman->tgl_pengembalian_user ?? now(),
        ]);

        return redirect()->back()->with('success', 'Alat berhasil dikembalikan.');
    }
}
