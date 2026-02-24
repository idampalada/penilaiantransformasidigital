<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class UnorIndikator extends Model
{
    protected $table = 'unor_indikators';

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
        return $this->hasMany(UnorPenilaian::class, 'indikator_id');
    }

    // Relasi ke bukti (kalau masih dipakai)
    public function bukti()
    {
        return $this->hasMany(\App\Models\UnorBukti::class, 'unor_indikator_id');
    }
}
