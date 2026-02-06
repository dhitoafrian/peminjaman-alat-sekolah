<?php

namespace App\Http\Controllers\Admin;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
    public function approve($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $alat = $peminjaman->alat;

        // Cek stok
        if ($alat->stok > 0) {
            // Kurangi stok
            $alat->decrement('stok');

            // Update status peminjaman
            $peminjaman->update([
                'status' => 'approved'
            ]);

            return redirect()->back()->with('success', 'Peminjaman berhasil disetujui.');
        } else {
            return redirect()->back()->with('error', 'Stok alat habis, tidak dapat menyetujui peminjaman.');
        }
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
    public function return($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status === 'approved') {
            $alat = $peminjaman->alat;

            // Tambah stok kembali
            $alat->increment('stok');

            // Update peminjaman
            $peminjaman->update([
                'status' => 'returned',
                'tgl_kembali' => now()
            ]);

            return redirect()->back()->with('success', 'Alat berhasil dikembalikan.');
        }

        return redirect()->back()->with('error', 'Peminjaman tidak dalam status approved.');
    }
}
