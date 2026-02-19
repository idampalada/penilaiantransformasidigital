<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ZiIndikator extends Model
{
    protected $table = 'zi_indikators';

    protected $fillable = [
        'nomor',
        'kategori',
        'kriteria',
        'indikator',
        'komponen',
        'metode_pengukuran',
        'penilaian',
        'bukti_persyaratan',
        'is_active',
    ];

    // Relasi ke penilaian (multi-unit)
    public function penilaians()
    {
        return $this->hasMany(ZiPenilaian::class, 'indikator_id');
    }

    // Relasi ke bukti (kalau masih dipakai)
    public function bukti()
    {
        return $this->hasMany(\App\Models\ZiBukti::class, 'zi_indikator_id');
    }
}
