<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Cek role user
        $user = auth()->user();

        if ($user->role === 'admin') {
            // Dashboard Admin: Data ringkasan
            $jumlahAlat = Alat::count();
            $peminjamanPending = Peminjaman::where('status', 'pending')->count();
            $peminjamanApproved = Peminjaman::where('status', 'dipinjam')->count();
            $totalPeminjaman = Peminjaman::count();

            return view('dashboard.admin', compact(
                'jumlahAlat',
                'peminjamanPending',
                'peminjamanApproved',
                'totalPeminjaman'
            ));
        } else {
            // Dashboard User: Katalog alat
            $alats = Alat::all();

            return view('dashboard.user', compact('alats'));
        }
    }
}
