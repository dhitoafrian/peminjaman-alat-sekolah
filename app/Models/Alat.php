<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'foto',
        'deskripsi',
        'stok',
        'kondisi',
        'status',
    ];

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

}
