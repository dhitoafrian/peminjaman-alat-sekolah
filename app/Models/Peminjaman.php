<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'alat_id',
        'jumlah',
        'keterangan',
        'tgl_pinjam',
        'tgl_kembali_admin',
        'tgl_pengembalian_user',
        'status',
    ];

    // mengkonversi tipe data secara otomatis saat di ambil
    protected $casts = [
        'tgl_pinjam' => 'date',
        'tgl_kembali_admin' => 'date',
        'tgl_pengembalian_user' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function alat()
    {
        return $this->belongsTo(Alat::class);
    }
}
