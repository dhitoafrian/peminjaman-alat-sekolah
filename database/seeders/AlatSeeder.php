<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Alat;

class AlatSeeder extends Seeder
{
    public function run(): void
    {
        $alats = [
            [
                'nama' => 'Laptop Dell Latitude',
                'foto' => 'alat/Laptop.jpg',
                'stok' => 5,
                'deskripsi' => 'Laptop untuk keperluan kerja dan presentasi'
            ],
            [
                'nama' => 'Proyektor Epson',
                'foto' => 'alat/proyektor.jpg',
                'stok' => 3,
                'deskripsi' => 'Proyektor HD untuk presentasi'
            ],
            [
                'nama' => 'Mikrofon Wireless',
                'foto' => 'alat/mikrofon.jpg',
                'stok' => 4,
                'deskripsi' => 'Mikrofon wireless untuk acara'
            ],
            [
                'nama' => 'Tripod Kamera',
                'foto' => 'alat/tripod.jpg',
                'stok' => 6,
                'deskripsi' => 'Tripod untuk kamera dan smartphone'
            ],
            [
                'nama' => 'Extension Cable 10m',
                'foto' => 'alat/extension.jpg',
                'stok' => 8,
                'deskripsi' => 'Kabel ekstensi 10 meter'
            ],
            [
                'nama' => 'Sapu',
                'foto' => 'alat/sapu.jpg',
                'stok' => 11,
                'deskripsi' => 'Alat kebersihan'
            ],
        ];

        foreach ($alats as $alat) {
            Alat::create($alat);
        }
    }
}
