<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mitra extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_mitra',
        'alamat',
        'nomor_telepon',
        'tahun_awal_kerjasama',
        'tahun_akhir_kerjasama'
    ];

    // Accessor untuk periode kerjasama
    public function getPeriodeKerjasamaAttribute()
    {
        return $this->tahun_awal_kerjasama . ' - ' . $this->tahun_akhir_kerjasama;
    }
}
