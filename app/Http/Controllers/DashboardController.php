<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Cek role user
        $user = auth()->user();

        if ($user->role === 'admin') {
            $totalAlat = Alat::count();
            $totalUser = User::where('role', 'user')->count(); // Hitung siswa aja
            $sedangDipinjam = Peminjaman::where('status', 'approved')->count();
            $permintaanPending = Peminjaman::where('status', 'pending')->count();

            // 2. Data Tabel "Action Needed" (Ambil 5 terbaru aja)
            $latestPeminjamans = Peminjaman::where('status', 'pending')
                ->with(['user', 'alat'])
                ->latest()
                ->limit(5)
                ->get();

            // 3. Data "Stok Menipis" (Misal kurang dari 3)
            $stokMenipis = Alat::where('stok', '<', 3)->where('stok', '>', 0)->limit(5)->get();

            return view('dashboard.admin', compact(
                'totalAlat',
                'totalUser',
                'sedangDipinjam',
                'permintaanPending',
                'latestPeminjamans',
                'stokMenipis'
            ));
        } else {
            // Dashboard User: Katalog alat
            $query = Alat::query();

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $search . '%');
            }

            $alats = $query->get();

            return view('dashboard.user', compact('alats'));
        }
    }
}
