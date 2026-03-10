<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class UptIndikator extends Model
{
    protected $table = 'upt_indikators';

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
    return $this->hasMany(UptPenilaian::class, 'indikator_id');
}
    // Relasi ke bukti (kalau masih dipakai)
    public function bukti()
    {
        return $this->hasMany(\App\Models\UptBukti::class, 'upt_indikator_id');
    }
}
