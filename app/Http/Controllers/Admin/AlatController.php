<?php

namespace App\Http\Controllers\Admin;

use App\Models\Alat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AlatController extends Controller
{
    // Tampilkan daftar alat
    public function index()
    {
        $alats = Alat::all();
        return view('admin.alat.index', compact('alats'));
    }

    // Form tambah alat
    public function create()
    {
        return view('admin.alat.create');
    }

    // A. Simpan alat baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string'
        ]);

        $data = $request->all();

        // Upload foto
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('alat', 'public');
        }

        Alat::create($data);

        return redirect()->route('admin.alat.index')
            ->with('success', 'Alat berhasil ditambahkan.');
    }

    // Form edit alat
    public function edit($id)
    {
        $alat = Alat::findOrFail($id);
        return view('admin.alat.edit', compact('alat'));
    }

    // B. Update alat
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stok' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string'
        ]);

        $alat = Alat::findOrFail($id);
        $data = $request->all();

        // Upload foto baru jika ada
        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($alat->foto && Storage::disk('public')->exists($alat->foto)) {
                Storage::disk('public')->delete($alat->foto);
            }

            $data['foto'] = $request->file('foto')->store('alat', 'public');
        }

        $alat->update($data);

        return redirect()->route('admin.alat.index')
            ->with('success', 'Alat berhasil diupdate.');
    }

    // C. Hapus alat
    public function destroy($id)
    {
        $alat = Alat::findOrFail($id);

        // Cek apakah alat sedang dipinjam
        $dipinjam = $alat->peminjamanAktif()->count();

        if ($dipinjam > 0) {
            return redirect()->back()
                ->with('error', 'Alat tidak dapat dihapus karena sedang dipinjam.');
        }

        // Hapus foto jika ada
        if ($alat->foto && Storage::disk('public')->exists($alat->foto)) {
            Storage::disk('public')->delete($alat->foto);
        }

        $alat->delete();

        return redirect()->route('admin.alat.index')
            ->with('success', 'Alat berhasil dihapus.');
    }
}
